<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    // Display a listing of the warranties.
    public function index()
    {
        // Logic to retrieve and return all warranties

        $userId = Auth::id();
        $warranties = Warranty::where('user_id', $userId)->get();
        $productNames = Product::pluck('name', 'id'); // returns [id => name]




        return view('warranty.modify',
            [
                "pageTitle"       => "Modify Warranty Request",
                "pageDescription" => "Modify Warranty Request",
                "pageScript"      => "warranty",
                "warranties"      => $warranties,
                "productNames"    => $productNames
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
                "products"        => $products
            ]);
    }

    // Store a newly created warranty in storage.
    public function store(Request $request)
    {

        // echo "hello";exit;
        // Validate the request data
        $request->validate([
            'product_type'         => 'required|string',
            'qty_purchased'        => 'required|integer',
            'application'          => in_array(
                                        $request->input('product_type'), ['Greenlam Clads',
                                        'Greenlam Sturdo']) ? ['sometimes', 'nullable',
                                        'string'] : ['required', 'string'],
            'place_of_purchase'    => 'required|string',
            'invoice_number'       => 'required|string',
            'upload_invoice'       => 'required|file|mimes:jpg,png,pdf,jpeg,doc,docx|max:2048',
            'handover_certificate' => 'nullable|file|mimes:jpg,png,pdf,jpeg,doc,docx|max:2048', // optional field

        ]);

        // Handle file uploads
        $dateTimeString = strtotime(date('Y-m-d H:i:s'));

        if ($request->hasFile('upload_invoice')) {
            $invoiceFileName = 'invoice_' . Auth::user()->id . '_' . $dateTimeString . '.' . $request->file('upload_invoice')->getClientOriginalExtension();
            $invoicePath     = $request->file('upload_invoice')->storeAs('invoices', $invoiceFileName, 'public');
        }

        if ($request->hasFile('handover_certificate')) {
            $handoverFileName = 'handover_certificate_' . Auth::user()->id . '_' . $dateTimeString . '.' . $request->file('handover_certificate')->getClientOriginalExtension();
            $handoverPath     = $request->file('handover_certificate')->storeAs('handover_certificates', $handoverFileName, 'public');
        }

        // Store the data in the database
        $warranty                            = new Warranty();
        $warranty->product_type              = $request->input('product_type');
        $warranty->qty_purchased             = $request->input('qty_purchased');
        $warranty->application               = $request->input('application');
        $warranty->place_of_purchase         = $request->input('place_of_purchase');
        $warranty->invoice_number            = $request->input('invoice_number');
        $warranty->invoice_path              = $invoicePath ?? null;
        $warranty->handover_certificate_path = $handoverPath ?? null;
        $warranty->user_id                   = Auth::user()->id;
        try {
            $warranty->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering warranty'], 500);
        }

        return response()->json(['message' => 'Warranty registered successfully']);
    }

    // Display the specified warranty.
    public function show($id)
    {
        // Logic to retrieve and display a specific warranty
    }

    // Show the form for editing the specified warranty.
    public function edit($id)
    {
        $warranty = Warranty::findOrFail($id);
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
        // Validate the request data
        $request->validate([
            'product_type'         => 'required|string',
            'qty_purchased'        => 'required|integer',
            'application'          => in_array(
                                        $request->input('product_type'), ['Greenlam Clads',
                                        'Greenlam Sturdo']) ? ['sometimes', 'nullable',
                                        'string'] : ['required', 'string'],
            'place_of_purchase'    => 'required|string',
            'invoice_number'       => 'required|string',
            'upload_invoice'       => 'nullable|file|mimes:jpg,png,pdf,jpeg,doc,docx|max:2048',
            'handover_certificate' => ($request->input('product_type') === '2' && Warranty::findOrFail($id)->handover_certificate_path === null) ? ['required', 'file', 'mimes:jpg,png,pdf,jpeg,doc,docx', 'max:2048'] : ['nullable', 'file', 'mimes:jpg,png,pdf,jpeg,doc,docx', 'max:2048'],
        ]);

        $warranty = Warranty::findOrFail($id);
        if ($warranty->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized to update this warranty'], 403);
        }

        // Handle file uploads if provided
        $dateTimeString = strtotime(date('Y-m-d H:i:s'));

        if ($request->hasFile('upload_invoice')) {
            $invoiceFileName = 'invoice_' . Auth::user()->id . '_' . $dateTimeString . '.' . $request->file('upload_invoice')->getClientOriginalExtension();
            $invoicePath     = $request->file('upload_invoice')->storeAs('invoices', $invoiceFileName, 'public');
            $warranty->invoice_path = $invoicePath;
        }

        if ($request->hasFile('handover_certificate')) {
            $handoverFileName = 'handover_certificate_' . Auth::user()->id . '_' . $dateTimeString . '.' . $request->file('handover_certificate')->getClientOriginalExtension();
            $handoverPath     = $request->file('handover_certificate')->storeAs('handover_certificates', $handoverFileName, 'public');
            $warranty->handover_certificate_path = $handoverPath;
        }

        // Update the warranty data
        $warranty->product_type              = $request->input('product_type');
        $warranty->qty_purchased             = $request->input('qty_purchased');
        $warranty->application               = $request->input('application');
        $warranty->place_of_purchase         = $request->input('place_of_purchase');
        $warranty->invoice_number            = $request->input('invoice_number');
        $warranty->status                    = 'pending'; // Reset status to pending after modification

        try {
            $warranty->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating warranty'], 500);
        }

        return response()->json(['message' => 'Warranty updated successfully']);
    }

    // Remove the specified warranty from storage.
    public function destroy($id)
    {
        // Logic to delete a specific warranty
    }
}
