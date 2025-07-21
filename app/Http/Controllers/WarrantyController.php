<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warranty;
use App\Models\WarrantyProduct;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WarrantyController extends Controller
{
    // Display a listing of the warranties.
    public function index()
    {
        // Logic to retrieve and return all warranties

        $userId     = Auth::id();
        $warranties = WarrantyRegistration::with(['products.product'])
            ->where('user_id', $userId)
            ->paginate(10);
        $productNames = Product::pluck('name', 'id'); // returns [id => name]

        return view('warranty.modify',
            [
                "pageTitle"       => "Modify Warranty Request",
                "pageDescription" => "Modify Warranty Request",
                "pageScript"      => "warranty",
                "warranties"      => $warranties,
                "productNames"    => $productNames,
            ]);
    }

    // Show the form for creating a new warranty.
    public function create()
    {
        $products = Product::all();

        return view('warranty.create',
            [
                "pageTitle"       => "Warranty Registration",
                "pageDescription" => "Warranty Registration",
                "pageScript"      => "warranty",
                "products"        => $products,
            ]);
    }

    // Store a newly created warranty in storage.
    public function store(Request $request)
    {

        $validated = $request->validate([
            'dealer_name'            => 'required|string|max:255',
            'dealer_city'            => 'required|string|max:255',
            // 'place_of_purchase'      => 'required|string|max:255',
            'invoice_number'         => 'required|string|max:255',
            'upload_invoice'         => 'required|file|mimes:jpg,png,pdf,doc,docx|max:10048',

            'product_type.*'         => 'required|integer|exists:products,id',
            'qty_purchased.*'        => 'required|integer|min:1',
            'application.*'          => 'nullable|string',
            'handover_certificate.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:10048',
            'dealer_state'           => 'required|string|max:255',

        ]);

        // Save dealer details
        $registration                    = new WarrantyRegistration();
        $registration->dealer_name       = $validated['dealer_name'];
        $registration->dealer_city       = $validated['dealer_city'];
        $registration->dealer_state      = $validated['dealer_state'];
        // $registration->place_of_purchase = $validated['place_of_purchase'];
        $registration->invoice_number    = $validated['invoice_number'];
        $registration->user_id           = Auth::id();

        $dateTimeString = strtotime(date('Y-m-d H:i:s'));

        // Save invoice file
        if ($request->hasFile('upload_invoice')) {
            $file        = $request->file('upload_invoice');
            $filename    = 'invoice_' . Auth::user()->id . '_' . $dateTimeString . '.' . $request->file('upload_invoice')->getClientOriginalExtension();
            $invoicePath = $request->file('upload_invoice')->storeAs('invoices', $filename, 'public');
            // $filename = time().'_'.$file->getClientOriginalName();
            // $file->move(public_path('uploads/invoices'), $filename);
            $registration->upload_invoice = $invoicePath;
        }

        $registration->save();

        // Save each product row
        $productTypes         = $validated['product_type'];
        $quantities           = $validated['qty_purchased'];
        $applications         = $validated['application'];
        $handoverCertificates = $request->file('handover_certificate');

        foreach ($productTypes as $index => $productType) {
            $product                           = new WarrantyProduct();
            $product->warranty_registration_id = $registration->id;
            $product->product_type             = $productType;
            $product->qty_purchased            = $quantities[$index];
            $product->application_type         = $applications[$index] ?? null;

            // Save handover certificate if uploaded
            if (isset($handoverCertificates[$index])) {
                $handoverFile = $handoverCertificates[$index];
                $filename     = 'invoice_' . Auth::user()->id . '_' . $dateTimeString . '.' . $handoverFile->getClientOriginalExtension();
                $handoverPath = $handoverFile->storeAs('handover_certificates', $filename, 'public');
                $product->handover_certificate = $handoverPath;
            }

            $product->save();
        }

        return response()->json(['success' => true, 'message' => 'Warranty registered successfully']);

    }

    // Display the specified warranty.
    public function show($id)
    {
        // Logic to retrieve and display a specific warranty
    }

    // Show the form for editing the specified warranty.
    public function edit($id)
    {
        $warranty = WarrantyRegistration::with('products')->findOrFail($id);
        if ($warranty->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized to access this warranty'], 403);
        }
        // return response()->json($warranty);

        //  $productNames = Product::pluck('name', 'id'); // returns [id => name]
        $products = Product::all();

        return view('warranty.modifymodal', [
            'warranty' => $warranty,
            'products' => $products,
        ]);
    }

    // Update the specified warranty in storage.
    public function update(Request $request, $id)
{
    $warranty = WarrantyRegistration::findOrFail($id);

    // Validate fields here (like in create)

    $warranty->dealer_name = $request->dealer_name;
    $warranty->dealer_city = $request->dealer_city;
    $warranty->place_of_purchase = $request->place_of_purchase;
    $warranty->invoice_number = $request->invoice_number;
    $warranty->status            = 'pending'; // Reset status to pending after modification

    $dateTimeString = now()->format('Ymd_His');

    // Update invoice file
    if ($request->hasFile('upload_invoice')) {
        // Optional: Delete old file
        if ($warranty->upload_invoice && Storage::disk('public')->exists($warranty->upload_invoice)) {
            Storage::disk('public')->delete($warranty->upload_invoice);
        }

        $file = $request->file('upload_invoice');
        $filename = 'invoice_' . Auth::id() . '_' . $dateTimeString . '.' . $file->getClientOriginalExtension();
        $invoicePath = $file->storeAs('invoices', $filename, 'public');
        $warranty->upload_invoice = $invoicePath;
    }

    $warranty->save();

    // Delete old products
    $warranty->products()->delete();

    // Save new products
    $productTypes = $request->product_type;
    $quantities = $request->qty_purchased;
    $applications = $request->application;
    $handoverCertificates = $request->file('handover_certificate');

    foreach ($productTypes as $index => $productType) {
        $product = new WarrantyProduct();
        $product->warranty_registration_id = $warranty->id;
        $product->product_type = $productType;
        $product->qty_purchased = $quantities[$index];
        $product->application_type = $applications[$index] ?? null;

        // Save handover file
        if (isset($handoverCertificates[$index])) {
            $handoverFile = $handoverCertificates[$index];

            $handoverFilename = 'handover_' . Auth::id() . '_' . $dateTimeString . '_' . $index . '.' . $handoverFile->getClientOriginalExtension();
            $handoverPath = $handoverFile->storeAs('handover_certificates', $handoverFilename, 'public');

            $product->handover_certificate = $handoverPath;
        }

        $product->save();
    }

    return response()->json(['message' => 'Warranty updated successfully']);
}

    // Remove the specified warranty from storage.
    public function destroy($id)
    {
        // Logic to delete a specific warranty
    }
}
