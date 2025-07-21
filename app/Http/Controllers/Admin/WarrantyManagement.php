<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserProduct;
use App\Models\WarrantyProduct;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyManagement extends Controller
{
    public function index(Request $request)
    {
        // Code to list warranties
        $userId = Auth::id();
        if (Auth::user()->hasRole('admin')) {
            // $warranties = Warranty::all();

            $warranties = WarrantyRegistration::with(['products.product'])
                ->orderBy('id', 'desc')
            // ->paginate(2);
                ->get();

        } else {
            // $productIds = UserProduct::where('user_id', $userId)->pluck('product_id')->toArray();
            $productIds = UserProduct::where('user_id', $userId)
                ->value('product_id');

            $productIds = array_filter(array_map('trim', explode(',', $productIds)));

            $warranties = WarrantyRegistration::with(['products.product'])
                ->where('user_id', $userId)
                ->whereHas('products', function ($query) use ($productIds) {
                    $query->whereIn('product_type', $productIds);
                })->orderBy('id', 'desc')
                ->paginate(10);

            // $productIds = UserProduct::where('user_id', $userId)->value('product_id');
            // $productIds = explode(',', $productIds); // convert to array
            // $warranties = Warranty::whereIn('product_type', $productIds)->get();
            // dd($warranties);
        }
        $productNames = Product::pluck('name', 'id'); // returns [id => name]

        return view('admin.warranty.index',
            [
                "pageTitle"       => "Warranty Management",
                "pageDescription" => "Warranty Management",
                "pageScript"      => "warrantyadmin",
                "warranties"      => $warranties,
                "productNames"    => $productNames,
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
        $warranty = WarrantyRegistration::findOrFail($id);
        if (Auth::user()->hasRole('admin')) {
            $warrantyProducts = WarrantyProduct::with('product')->where('warranty_registration_id', $id)->get();
        } elseif (Auth::user()->hasRole('editor')) {
            $userProducts     = UserProduct::where('user_id', Auth::id())->value('product_id');
            $userProducts     = explode(',', $userProducts);
            $warrantyProducts = WarrantyProduct::with('product')->where('warranty_registration_id', $id)->whereIn('product_type', $userProducts)->get();
        }

        // return response()->json($warranty);

        return view('admin.warranty.editmodal', [
            'warranty'         => $warranty,
            'warrantyProducts' => $warrantyProducts,
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
                'total_quantity.required'   => 'Please enter total quantity for all products.',
                'total_quantity.array'      => 'Invalid total quantity.',
                'total_quantity.*.required' => 'Please enter total quantity for all products.',
                'total_quantity.*.integer'  => 'Invalid total quantity.',
                'total_quantity.*.min'      => 'Total quantity should be at least 1.',
                'product_status.required'   => 'Please select status for all products.',
                'product_status.array'      => 'Invalid status selection.',
                'product_status.*.required' => 'Please select status for all products.',
                'product_status.*.in'       => 'Invalid status selection.',
                'product_remarks.array'     => 'Invalid remarks.',
                'product_remarks.*.string'  => 'Invalid remarks.',
                'product_remarks.*.max'     => 'Remarks should not be more than 500 characters.',
                'product_remarks.*.required' => 'Please enter remarks for all products.',
                // 'product_remarks.required'  => 'Please enter remarks for all products.',
            ]);

        // Loop through and update each product

        $warrantyStatus='approved';

        foreach ($request->product_id as $index => $pid) {
            $warrantyProduct = WarrantyProduct::find($pid);

            if ($warrantyProduct) {

                if($request->product_status[$index]=='pending' || $request->product_status[$index]=='modify') {
                    $warrantyStatus='modify';
                }

                $warrantyProduct->total_quantity = $request->total_quantity[$index];
                $warrantyProduct->product_status         = $request->product_status[$index];
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
}
