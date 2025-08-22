<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Models\BranchEmail;
use App\Models\Product;
use App\Models\UserProduct;
use App\Models\WarrantyLog;
use App\Models\WarrantyProduct;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WarrantyManagement extends Controller
{
    public function index(Request $request)
    {
        // Code to list warranties
        $userId     = Auth::id();
        $productIds = [];
        if (Auth::user()->hasRole('admin')) {
            // $warranties = Warranty::all();

            $warranties = WarrantyRegistration::with(['products.product'])
                ->orderBy('id', 'desc')
            // ->paginate(2);
                ->get();

        } else if (Auth::user()->hasRole('country_admin')) {
            // $productIds = UserProduct::where('user_id', $userId)->pluck('product_id')->toArray();
            $productId = UserProduct::where('user_id', $userId)
                ->value('product_id');

                // echo "mKKKK".$productId;

            $warranties = WarrantyRegistration::whereHas('products', function ($q) use ($productId) {
                $q->where('product_type', $productId)
                    ->where('branch_admin_status', 'approved');
            })
                ->with([
                    'products' => function ($q) use ($productId) {
                        $q->where('product_type', $productId)
                            ->where('branch_admin_status', 'approved');
                    },
                    'products.product',
                ])
                ->orderBy('id', 'desc')
                ->paginate(10);

        } else if (Auth::user()->hasRole('branch_admin')) {

            $cities = BranchEmail::where('commercial_email', Auth::user()->email)->pluck('city')->toArray();
            $states = BranchEmail::where('commercial_email', Auth::user()->email)->pluck('state')->toArray();

            $warranties = WarrantyRegistration::with(['products.product'])
                ->whereIn('dealer_city', $cities)
                ->whereIn('dealer_state', $states)
                ->whereHas('products', function ($q) {
                    $q->where('country_admin_status', '!=', 'approved');
                })
                ->orderBy('id', 'desc')
                ->paginate(10);

        }

        $productNames = Product::pluck('name', 'id'); // returns [id => name]

        return view('admin.warranty.index',
            [
                "pageTitle"       => "Warranty Management",
                "pageDescription" => "Warranty Management",
                "pageScript"      => "warrantyadmin",
                "warranties"      => $warranties,
                "productNames"    => $productNames,
                "productIds"      => $productIds,
            ]);

    }

    public function create()
    {
        // Code to show the form for creating a new warranty
    }

    public function store(Request $request)
    {
        // Code to store a new warranty
    }

    public function show($id)
    {
        // Code to display a specific warranty
    }

    public function edit($id)
    {
        $warranty = WarrantyRegistration::with('logs', 'logs.user')->findOrFail($id);
        $remarks  = $warranty->remarks()->with('user')->latest()->get();
        if (Auth::user()->hasRole('admin')) {
            $warrantyProducts = WarrantyProduct::with('product')->where('warranty_registration_id', $id)->get();
        } elseif (Auth::user()->hasRole('country_admin')) {
            $userProducts     = UserProduct::where('user_id', Auth::id())->value('product_id');
            $userProducts     = explode(',', $userProducts);
            $warrantyProducts = WarrantyProduct::with('product')->where('warranty_registration_id', $id)->whereIn('product_type', $userProducts)->get();
        } else if (Auth::user()->hasRole('branch_admin')) {
            // $warrantyProducts = WarrantyProduct::with('product')->where('warranty_registration_id', $id)->get();
            $warrantyProducts = WarrantyProduct::with('product')
                ->where('warranty_registration_id', $id)
                ->where('country_admin_status', '!=', 'approved')
                ->get();

        }

        // return response()->json($warranty);

        return view('admin.warranty.edit', [
            'warranty'         => $warranty,
            'warrantyProducts' => $warrantyProducts,
            'remarks'          => $remarks,
            'pageTitle'        => 'Warranty Management',
            'pageDescription'  => 'Warranty Management',
            'pageScript'       => 'warrantyadmin',
        ]);
    }

    public function update(Request $request, $id)
    {

        // Validate the form data
        $validatedData = $request->validate([
            // 'product_id'        => 'required|array',
            // 'product_id.*'      => 'required|integer|exists:warranty_products,id',
            'total_quantity'    => 'required|array',
            'total_quantity.*'  => 'required|integer|min:1',
            'product_status'    => 'required|array',
            'product_status.*'  => 'required|in:pending,modify,approved',
            'product_remarks'   => 'required|array',
            'product_remarks.*' => 'required|string|max:500',
        ],
            [
                'total_quantity.required'    => 'Please enter total quantity for all products.',
                'total_quantity.array'       => 'Invalid total quantity.',
                'total_quantity.*.required'  => 'Please enter total quantity for all products.',
                'total_quantity.*.integer'   => 'Invalid total quantity.',
                'total_quantity.*.min'       => 'Total quantity should be at least 1.',
                'product_status.required'    => 'Please select status for all products.',
                'product_status.array'       => 'Invalid status selection.',
                'product_status.*.required'  => 'Please select status for all products.',
                'product_status.*.in'        => 'Invalid status selection.',
                'product_remarks.array'      => 'Invalid remarks.',
                'product_remarks.*.string'   => 'Invalid remarks.',
                'product_remarks.*.max'      => 'Remarks should not be more than 500 characters.',
                'product_remarks.*.required' => 'Please enter remarks for all products.',
                // 'product_remarks.required'  => 'Please enter remarks for all products.',
            ]);

        // Loop through and update each product

        $warrantyStatus = 'approved';

        foreach ($request->product_id as $index => $pid) {
            $warrantyProduct = WarrantyProduct::find($pid);

            if ($warrantyProduct) {

                $hasPendingOrModify = WarrantyProduct::where('warranty_registration_id', $id)
                    ->whereIn('product_status', ['pending', 'modify'])
                    ->exists();

                if ($hasPendingOrModify) {
                    $warrantyStatus = 'modify';
                }

                $warrantyProduct->total_quantity = $request->total_quantity[$index];
                $warrantyProduct->product_status = $request->product_status[$index];
                $warrantyProduct->remarks        = $request->product_remarks[$index] ?? null;
                $warrantyProduct->save();
            }
        }

        $warranty = WarrantyRegistration::findOrFail($id);

        // Update the warranty status and remarks
        $warranty->status      = $warrantyStatus;
        $warranty->modified_by = Auth::id();
        $warranty->checked_by  = Auth::id();
        $warranty->save();

        // return redirect()->back()->with('success', 'Warranty products updated successfully.');

        return response()->json(['message' => 'Warranty updated successfully']);

    }

    public function destroy($id)
    {
        // Code to delete a specific warranty
    }

    public function updateProduct(Request $request, $id)
    {
        $validations = [
            'total_quantity'            => 'required|numeric|min:1',
            'product_remarks'           => 'nullable|string|max:500',
            'product_name'              => 'sometimes|nullable|string|max:255',
            'products_json'             => 'nullable|json',
            'products_jsonFloor'             => 'nullable|json',
            'warranty_years'            => 'nullable|string|max:50',
            'date_of_issuance'          => 'nullable|date',
            'invoice_date'              => 'nullable|date',
            'execution_agency'          => 'nullable|string|max:255',
            'handover_certificate_date' => 'nullable|date',
            'product_code'              => 'nullable|string|max:255',
            'surface_treatment_type'    => 'nullable|string|max:255',
            'product_thickness'         => 'nullable|string|max:255',
            'project_location'          => 'nullable|string|max:255',
            'branch_name'               => 'nullable|string|max:255',
        ];

        if (Auth::user()->hasRole('country_admin')) {
            $validations['country_admin_status'] = 'required|in:pending,modify,approved';
        } elseif (Auth::user()->hasRole('branch_admin')) {
            $validations['branch_admin_status'] = 'required|in:pending,modify,approved';
        }
        // dd($request);

        $validated = $request->validate($validations);

        $product  = WarrantyProduct::findOrFail($id);
        $warranty = $product->registration; // assumes a belongsTo relation in WarrantyProduct

        $fieldsToLog = [
            'total_quantity'            => $validated['total_quantity'],
                                                                          // 'product_status' => $validated['product_status'],
            'remarks'                   => $validated['product_remarks'], // renamed from product_remarks to remarks
            'product_name'              => isset($validated['product_name']) ? $validated['product_name'] : null,
            'warranty_years'            => isset($validated['warranty_years']) ? $validated['warranty_years'] : null,
            'branch_name'               => $validated['branch_name'],
            // 'date_of_issuance' => $validated['date_of_issuance'],
            'invoice_date'              => $validated['invoice_date'],
            'execution_agency'          => $validated['execution_agency'],
            'handover_certificate_date' => $validated['handover_certificate_date'],
            'product_code'              => $validated['product_code'],
            'surface_treatment_type'    => $validated['surface_treatment_type'],
            'product_thickness'         => $validated['product_thickness'],
            'project_location'          => $validated['project_location'],
        ];

        if (Auth::user()->hasRole('country_admin')) {
            $fieldsToLog['country_admin_status'] = $validated['country_admin_status'];
        } elseif (Auth::user()->hasRole('branch_admin')) {
            $fieldsToLog['branch_admin_status'] = $validated['branch_admin_status'];
        }

        foreach ($fieldsToLog as $field => $newValue) {
            $oldValue = $product->$field;

            if ($oldValue != $newValue) {
                WarrantyLog::create([
                    'warranty_id'  => $warranty->id,
                    'field'        => $field,
                    'old_value'    => $oldValue,
                    'new_value'    => $newValue,
                    'updated_by'   => Auth::id(),
                    'product_type' => $product->product_type,
                ]);

                $product->$field = $newValue;
            }
        }

        $product->products_json = isset($validated['products_json']) ? $validated['products_json'] : null;
        $product->products_jsonFloor = isset($validated['products_jsonFloor']) ? $validated['products_jsonFloor'] : null;
        // Send email to the user
        if (isset($fieldsToLog['branch_admin_status']) && $fieldsToLog['branch_admin_status'] == 'modify') {
            MailHelper::sendMailCustomerModifyRequired($warranty->user->email);
        }

        if (isset($fieldsToLog['branch_admin_status']) && $fieldsToLog['branch_admin_status'] == 'approved') {

            Log::info("Sending email to the user for product type $product->product_type");


            $userProduct = UserProduct::where('product_id', $product->product_type)
                ->with('user')
                ->first();

            if ($userProduct) {
                Log::info("Sending email to " . $userProduct->user->email . "," . $userProduct->user->name . " for country approved by branch for product type $product->product_type");

                MailHelper::sendMailCountryApprovedByBranch($userProduct->user->email, $userProduct->user->name);
            }
        }

        $product->save();

        return response()->json(['message' => 'Saved successfully.']);
    }

    public function updateCountryAdminStatus(Request $request, $id)
    {
        // Validate the form data
        $validated = $request->validate([
            'country_admin_status'  => 'required|in:pending,rejected,approved',
            'country_admin_remarks' => 'required_if:country_admin_status,rejected,pending',
        ]);

        // Find the product
        $product = WarrantyProduct::findOrFail($id);

        // Log the changes if any
        $oldStatus  = $product->country_admin_status;
        $oldRemarks = $product->country_admin_remarks;

        if ($oldStatus != $validated['country_admin_status'] || $oldRemarks != ($validated['country_admin_remarks'] ?? '')) {
            WarrantyLog::create([
                'warranty_id' => $product->warranty_registration_id,
                'field'       => 'country_admin_status',
                'old_value'   => $oldStatus,
                'new_value'   => $validated['country_admin_status'],
                'updated_by'  => Auth::id(),
            ]);

            if ($oldRemarks != ($validated['country_admin_remarks'] ?? '')) {
                WarrantyLog::create([
                    'warranty_id' => $product->warranty_registration_id,
                    'field'       => 'country_admin_remarks',
                    'old_value'   => $oldRemarks,
                    'new_value'   => $validated['country_admin_remarks'] ?? '',
                    'updated_by'  => Auth::id(),
                ]);
            }

            $product->country_admin_status  = $validated['country_admin_status'];
            $product->country_admin_remarks = $validated['country_admin_remarks'] ?? '';

            if ($validated['country_admin_status'] === 'approved') {
                $product->date_of_issuance = now(); // Set issue date to current date

                if ($product->registration) {
                    $warranty = $product->registration;
                    Log::info("Sending email to " . $warranty->user->email . " for country approved ");

                    MailHelper::sendMailApprovedCustomer($warranty->user->email);
                }

            }

            $product->save();
        }

        return redirect()->back()->with('success', 'Country admin status updated successfully.');
    }

}
