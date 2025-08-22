<?php
namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\BranchEmail;
use App\Models\Product;
use App\Models\User;
use App\Models\WarrantyProduct;
use App\Models\WarrantyRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        $messages = [
            'dealer_name.required'            => 'The dealer name is required.',
            'dealer_name.max'                 => 'The dealer name must not be greater than 255 characters.',
            'dealer_city.required'            => 'The dealer city is required.',
            'dealer_city.max'                 => 'The dealer city must not be greater than 255 characters.',
            // 'place_of_purchase.required' => 'The place of purchase is required.',
            // 'place_of_purchase.max'      => 'The place of purchase must not be greater than 255 characters.',
            'invoice_number.required'         => 'The invoice number is required.',
            'invoice_number.max'              => 'The invoice number must not be greater than 255 characters.',
            'upload_invoice.required'         => 'An invoice file is required.',
            'upload_invoice.mimes'            => 'Invoice file must be an image (jpg, png), PDF, DOC or DOCX.',
            'upload_invoice.max'              => 'Invoice file must not be greater than 10MB.',
            'dealer_state.required'           => 'The dealer state is required.',
            'dealer_state.max'                => 'The dealer state must not be greater than 255 characters.',
            'product_type.*.required'         => 'The product type is required.',
            'product_type.*.exists'           => 'The product type does not exist.',
            'qty_purchased.*.required'        => 'The quantity purchased is required.',
            'qty_purchased.*.min'             => 'The quantity purchased must be at least 1.',
            'application.*.nullable'          => 'The application is nullable.',
            'application.*.string'            => 'The application must be a string.',
            'handover_certificate.*.nullable' => 'The handover certificate is nullable.',
            'handover_certificate.*.mimes'    => 'Handover certificate file must be an image (jpg, png), PDF, DOC or DOCX.',
            'handover_certificate.*.max'      => 'Handover certificate file must not be greater than 10MB.',
            'handover_certificate.*.required' => 'Handover certificate is required.',
            'handover_certificate.*.mimes'    => 'Allowed file types: jpg, png, pdf, doc, docx',
            'handover_certificate.*.max'      => 'Max file size is 2MB',
            'application.*.required'          => 'Application type is required',
        ];

        $validator = Validator::make($request->all(), [
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

        ], $messages);

        // Conditional rule for product type 2 or 4
        foreach ($request->product_type as $key => $productType) {
            if (in_array($productType, [2, 4, 5])) {
                $validator->sometimes("handover_certificate.$key", 'required', function () {return true;});
            }
        }

        foreach ($request->product_type as $key => $productType) {
            if (! in_array($productType, [4, 6])) {
                $validator->sometimes("application.$key", 'required', fn() => true);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Save dealer details
        $registration               = new WarrantyRegistration();
        $registration->dealer_name  = $validated['dealer_name'];
        $registration->dealer_city  = $validated['dealer_city'];
        $registration->dealer_state = $validated['dealer_state'];
        // $registration->place_of_purchase = $validated['place_of_purchase'];
        $registration->invoice_number = $validated['invoice_number'];
        $registration->user_id        = Auth::id();

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
                $handoverFile                  = $handoverCertificates[$index];
                $filename                      = 'invoice_' . Auth::user()->id . '_' . $dateTimeString . '.' . $handoverFile->getClientOriginalExtension();
                $handoverPath                  = $handoverFile->storeAs('handover_certificates', $filename, 'public');
                $product->handover_certificate = $handoverPath;
            }

            $product->save();
        }

        // Send email to customer
        MailHelper::sendMaiCustomerRequestSubmit($registration->user->email);

        $branchEmail = BranchEmail::where('state', $registration->dealer_state)
            ->where('city', $registration->dealer_city)
            ->value('commercial_email');

        if ($branchEmail) {

            $userName = User::where('email', $branchEmail)->value('name') ?? 'Branch Admin';
            MailHelper::sendMailBranchNewRequest($branchEmail, $userName);
        }

        return response()->json(['success' => true, 'message' => 'Thanks for submitting your warranty request, upon validation,
        we will be sending warranty details in 3-5 business days.', ], 200);

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

        $validated = $request->validate([
            // 'dealer_name'            => 'required|string|max:255',
            // 'dealer_city'            => 'required|string|max:255',
            // 'place_of_purchase'      => 'required|string|max:255',
            // 'dealer_state'           => 'required|string|max:255',
            'invoice_number'         => 'required|string|max:255',
            'upload_invoice'         => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:10048',

            'product_type.*'         => 'required|integer|exists:products,id',
            'qty_purchased.*'        => 'required|integer|min:1',
            'application.*'          => 'nullable|string',
            'handover_certificate.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:10048',

        ]);

        // $warranty->dealer_name = $request->dealer_name;
        // $warranty->dealer_city = $request->dealer_city;
        // $warranty->place_of_purchase = $request->place_of_purchase;
        $warranty->invoice_number = $request->invoice_number;
        // $warranty->status         = 'pending'; // Reset status to pending after modification

        $dateTimeString = now()->format('Ymd_His');

        // Update invoice file
        if ($request->hasFile('upload_invoice')) {
            // Optional: Delete old file
            if ($warranty->upload_invoice && Storage::disk('public')->exists($warranty->upload_invoice)) {
                Storage::disk('public')->delete($warranty->upload_invoice);
            }

            $file                     = $request->file('upload_invoice');
            $filename                 = 'invoice_' . Auth::id() . '_' . $dateTimeString . '.' . $file->getClientOriginalExtension();
            $invoicePath              = $file->storeAs('invoices', $filename, 'public');
            $warranty->upload_invoice = $invoicePath;
        }

        $warranty->save();

        $productIds           = $request->product_id; // hidden inputs
        $productTypes         = $request->product_type;
        $quantities           = $request->qty_purchased;
        $applications         = $request->application;
        $handoverCertificates = $request->file('handover_certificate');

        // dd($productIds);

        foreach ($productIds as $index => $productId) {
            if (! $productId) {
                // Skip rows without product_id
                continue;
            }

            $product = WarrantyProduct::find($productId);

            if (! $product) {
                // Skip if product not found in DB
                continue;
            }

            // Update fields
            $product->product_type        = $productTypes[$index];
            $product->qty_purchased       = $quantities[$index];
            $product->application_type    = $applications[$index] ?? null;
            $product->branch_admin_status = 'pending';

            // Update handover file only if a new one is uploaded
            if (isset($handoverCertificates[$index])) {
                $handoverFile = $handoverCertificates[$index];

                $handoverFilename = 'handover_' . Auth::id() . '_' . $dateTimeString . '_' . $index . '.' . $handoverFile->getClientOriginalExtension();
                $handoverPath     = $handoverFile->storeAs('handover_certificates', $handoverFilename, 'public');

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

    // List all certificates for a specific warranty.
    public function certificates()
    {
        // Logic to list certificates

        $userId     = Auth::id();
        $warranties = WarrantyRegistration::with(['products.product'])
            ->where('user_id', $userId)
            ->paginate(10);
        $productNames = Product::pluck('name', 'id'); // returns [id => name]

        return view('warranty.certificate',
            [
                "pageTitle"       => "Download Certificates",
                "pageDescription" => "Download Certificates",
                "pageScript"      => "warranty",
                "warranties"      => $warranties,
                "productNames"    => $productNames,
            ]
        );

    }

    public function getProducts(WarrantyRegistration $warranty)
    {
        $warranty->load('products.product');

        $html = view('warranty.partials.products_table', [
            'products' => $warranty->products,
        ])->render();

        return response()->json([
            'title' => "Products for Warranty #{$warranty->id}",
            'html'  => $html,
        ]);
    }

// Download a specific certificate.
    public function downloadCertificate($warrantyProductId, Request $request)
    {
        $userId          = Auth::id();
        $productName = $request->query('product');
        $warrantyProduct = WarrantyProduct::with(['product', 'registration', 'registration.user'])->where('id', $warrantyProductId)->first();
        // $warranty = WarrantyRegistration::where('user_id', $userId)
        //     ->whereHas('products', function ($query) use ($productType) {
        //         $query->where('product_type', $productType)
        //             ->where('branch_admin_status', 'approved')
        //             ->where('country_admin_status', 'approved');
        //     })
        //     ->first();

        $logoPath   = public_path('assets/images/greenlam-logo.png');
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logo       = 'data:image/png;base64,' . $logoBase64;

        $greenlamCladsLogoPath = public_path('assets/images/Greenlam-clads-logo.jpg');
        if ($warrantyProduct->product_type == 4) { //clads
            $greenlamCladsLogoPath = public_path('assets/images/Greenlam-clads-logo.jpg');
        } else if ($warrantyProduct->product_type == 6) { //sturdo
            $greenlamCladsLogoPath = public_path('assets/images/greenlam-sturdo.jpg');
        }

        $greenlamCladsLogoBase64 = base64_encode(file_get_contents($greenlamCladsLogoPath));
        $greenlamCladsLogo       = 'data:image/jpg;base64,' . $greenlamCladsLogoBase64;

        return view('warranty.download',
            [
                "pageTitle"         => "Download Warranty Certificate",
                "pageDescription"   => "Download Warranty Certificates",
                "pageScript"        => "warranty",
                // "warranty"      => $warranty,
                "warrantyProduct"   => $warrantyProduct,
                "logo"              => $logo,
                "greenlamCladsLogo" => $greenlamCladsLogo,
                "productName"       => $productName
            ]
        );

    }

    public function generatePDF($warrantyProductId)
    {
        $warrantyProduct = WarrantyProduct::with(['product', 'registration', 'registration.user'])->where('id', $warrantyProductId)->first();
        $logoPath        = public_path('assets/images/greenlam-logo.png');
        $logoBase64      = base64_encode(file_get_contents($logoPath));
        $logo            = 'data:image/png;base64,' . $logoBase64;

        $greenlamCladsLogoPath   = public_path('assets/images/Greenlam-clads-logo.jpg');
        $greenlamCladsLogoBase64 = base64_encode(file_get_contents($greenlamCladsLogoPath));
        $greenlamCladsLogo       = 'data:image/jpg;base64,' . $greenlamCladsLogoBase64;

        $data = [
            'warrantyProduct' => $warrantyProduct,
        ];

        $pdf = Pdf::loadView('warranty.download', compact('warrantyProduct', 'logo', 'greenlamCladsLogo'));

        return $pdf->download($warrantyProduct->product->name . '-Warranty-document.pdf');
    }

}
