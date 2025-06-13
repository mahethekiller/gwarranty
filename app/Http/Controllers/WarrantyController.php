<?php
namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    // Display a listing of the warranties.
    public function index()
    {
        // Logic to retrieve and return all warranties
    }

    // Show the form for creating a new warranty.
    public function create()
    {
        return view('warranty.create',
            [
                "pageTitle"       => "Warranty Registration",
                "pageDescription" => "Warranty Registration",
                "pageScript"      => "warranty",
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
        // Logic to show a form for editing an existing warranty
    }

    // Update the specified warranty in storage.
    public function update(Request $request, $id)
    {
        // Logic to validate and update an existing warranty
    }

    // Remove the specified warranty from storage.
    public function destroy($id)
    {
        // Logic to delete a specific warranty
    }
}
