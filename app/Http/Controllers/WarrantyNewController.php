<?php
namespace App\Http\Controllers;

use App\Models\ProductDetail;
use App\Models\ProductType;
use App\Models\ProductTypeVariant;
use App\Models\WarrantyRegistrationNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyNewController extends Controller
{
    // Product field configurations
    private $productFieldConfig = [
        'Mikasa Ply'      => [
            'required'  => ['variant'],
            'fields'    => ['variant', 'quantity'],
            'auto_fill' => ['uom' => 'PCS'],
        ],
        'Greenlam Clads'  => [
            'required'  => ['product_name_design', 'quantity'],
            'fields'    => ['product_name_design', 'quantity'],
            'auto_fill' => ['uom' => 'PCS'],
        ],
        'MikasaFx'        => [
            'required'  => ['product_name_design', 'quantity', 'site_address'],
            'fields'    => ['product_name_design', 'quantity', 'site_address'],
            'auto_fill' => ['uom' => 'PCS'],
        ],
        'Greenlam Sturdo' => [
            'required'  => ['product_category', 'no_of_boxes', 'site_address'],
            'fields'    => ['product_category', 'no_of_boxes', 'site_address'],
            'auto_fill' => ['uom' => 'Boxes'],
        ],
        'Mikasa Floors'   => [
            'required'  => ['variant'],
            'fields'    => ['variant', 'area_sqft'],
            'auto_fill' => ['uom' => 'Sq. Ft.'],
        ],
        'Mikasa Doors'    => [
            'required'  => ['quantity', 'handover_certificate', 'product_thickness'],
            'fields'    => ['quantity', 'handover_certificate', 'product_thickness', 'site_address'],
            'auto_fill' => ['uom' => 'PCS'],
        ],
    ];

    // Show warranty registration form
    public function create()
    {
        $productTypes = ProductType::with('variants')->where('is_active', true)->get();
        return view('warranty.createnew',
            [
                "pageTitle"       => "Warranty Registration",
                "pageDescription" => "Warranty Registration",
                "pageScript"      => "warrantynew",
                "productTypes"    => $productTypes,
            ]);
    }

    // Store warranty registration
    public function store(Request $request)
    {
        try {
            $validated = $this->validateWarrantyRequest($request);

            // Check if invoice number already exists
            $existingWarranty = WarrantyRegistrationNew::where('invoice_number', $request->invoice_number)->first();
            if ($existingWarranty) {
                return response()->json([
                    'success' => false,
                    'message' => 'This invoice number has already been registered. Please use a different invoice number.',
                ], 422);
            }

            // Upload invoice file
            if (! $request->hasFile('upload_invoice')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice file is required.',
                ], 422);
            }

            $invoicePath = $request->file('upload_invoice')->store('warranty/invoices', 'public');

            // Create warranty registration
            $warranty = WarrantyRegistrationNew::create([
                'user_id'           => Auth::id(),
                'dealer_name'       => $request->dealer_name,
                'dealer_state'      => $request->dealer_state,
                'dealer_city'       => $request->dealer_city,
                'invoice_number'    => $request->invoice_number,
                'invoice_date'      => $request->invoice_date,
                'invoice_file_path' => $invoicePath,
                'is_self_purchased' => $request->has('radio') && $request->radio === '1',
                'status'            => 'pending',
            ]);

            // Process each product
            $this->processProducts($request->products, $warranty->id);

            return response()->json([
                'success' => true,
                'message' => 'Warranty registration submitted successfully! You will receive a confirmation email shortly.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please fix the validation errors below.',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Warranty Registration Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again or contact support if the problem persists.',
            ], 500);
        }
    }

    // Validate warranty request
    private function validateWarrantyRequest(Request $request, $excludeWarrantyId = null)
    {
        $rules = [
            'dealer_name'                => 'required|string|max:255',
            'dealer_state'               => 'required|string',
            'dealer_city'                => 'required|string',
            'invoice_number'             => 'required|string|unique:warranty_registrations_new,invoice_number',
            'invoice_date'               => 'required|date',
            'upload_invoice'             => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'products'                   => 'required|array|min:1',
            'products.*.product_type_id' => 'required|exists:product_types,id',
        ];

        // Exclude current warranty from unique check for updates
        if ($excludeWarrantyId) {
            $rules['invoice_number'] = 'required|string|unique:warranty_registrations_new,invoice_number,' . $excludeWarrantyId;
            $rules['invoice_date']   = 'required|date';
            $rules['upload_invoice'] = 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048';
        }

        // Add dynamic validation rules based on product type
        foreach ($request->products ?? [] as $index => $product) {
            if (! empty($product['product_type_id'])) {
                $productType = ProductType::find($product['product_type_id']);
                if ($productType && isset($this->productFieldConfig[$productType->name])) {
                    $config = $this->productFieldConfig[$productType->name];

                    foreach ($config['required'] as $field) {
                        if ($field === 'variant') {
                            // Variant can come from either variant_id or variant input
                            $rules["products.$index.variant_id"] = 'required_without:products.' . $index . '.variant';
                            $rules["products.$index.variant"]    = 'required_without:products.' . $index . '.variant_id';
                        } else {
                            $rules["products.$index.$field"] = 'required';
                        }
                    }
                }
            }

            // Common rules for all products
            $rules["products.$index.handover_certificate"] = 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048';
            $rules["products.$index.no_of_boxes"]          = 'nullable|integer|min:0';
            $rules["products.$index.quantity"]             = 'nullable|integer|min:0';
            $rules["products.$index.area_sqft"]            = 'nullable|numeric|min:0';
            $rules["products.$index.invoice_date"]         = 'nullable|date';
            $rules["products.$index.invoice_number"]       = 'nullable|string';
            $rules["products.$index.site_address"]         = 'nullable|string';
            $rules["products.$index.product_thickness"]    = 'nullable|string';
        }

        return $request->validate($rules);
    }

    // Process products
    private function processProducts($products, $warrantyId)
    {
        foreach ($products as $productData) {
            $productType = ProductType::find($productData['product_type_id']);
            $config      = $this->productFieldConfig[$productType->name] ?? [];

            // Get variant value - either from variant_id or variant input
            $variantValue = null;
            if (! empty($productData['variant_id'])) {
                $variant      = ProductTypeVariant::find($productData['variant_id']);
                $variantValue = $variant ? $variant->variant_name : null;
            } elseif (! empty($productData['variant'])) {
                $variantValue = $productData['variant'];
            }

            // Upload handover certificate if exists
            $handoverPath = null;
            if (isset($productData['handover_certificate']) && $productData['handover_certificate']) {
                $handoverPath = $productData['handover_certificate']->store('warranty/handover_certificates', 'public');
            }

            // Auto-fill UoM based on product type
            $uomValue = $productData['uom'] ?? null;
            if (isset($config['auto_fill']) && empty($uomValue)) {
                $uomValue = $config['auto_fill']['uom'] ?? null;
            }

            // Create product detail
            ProductDetail::create([
                'warranty_registration_id' => $warrantyId,
                'product_type_id'          => $productData['product_type_id'],
                'variant_id'               => $productData['variant_id'] ?? null,
                'variant'                  => $variantValue,
                'product_name_design'      => $productData['product_name_design'] ?? null,
                'product_category'         => $productData['product_category'] ?? null,
                'no_of_boxes'              => $productData['no_of_boxes'] ?? null,
                'quantity'                 => $productData['quantity'] ?? null,
                'area_sqft'                => $productData['area_sqft'] ?? null,
                'handover_certificate'     => $handoverPath,
                'invoice_number'           => $productData['invoice_number'] ?? null,
                'invoice_date'             => $productData['invoice_date'] ?? null,
                'uom'                      => $uomValue,
                'site_address'             => $productData['site_address'] ?? null,
                'product_thickness'        => $productData['product_thickness'] ?? null,
            ]);
        }
    }

    // Get variants by product type
    public function getVariants($productTypeId)
    {
        $variants = ProductTypeVariant::where('product_type_id', $productTypeId)
            ->where('is_active', true)
            ->get();

        return response()->json($variants);
    }

    // Get product fields configuration
    public function getProductFields($productTypeId)
    {
        $productType = ProductType::findOrFail($productTypeId);

        $config = $this->productFieldConfig[$productType->name] ?? [
            'required'  => [],
            'fields'    => [],
            'auto_fill' => [],
        ];

        return response()->json([
            'fields'            => $config['fields'],
            'required'          => $config['required'],
            'auto_fill'         => $config['auto_fill'],
            'product_type_name' => $productType->name,
        ]);
    }

    // Add this method to WarrantyNewController
    public static function getCitiesByState($state)
    {
        // This should match your existing cities data structure
        // You might need to adjust based on how you store cities
        $statesWithCities = config('constants.states_with_cities', []);

        return $statesWithCities[$state] ?? [];
    }

    // List all warranties for the authenticated user
    public function index()
    {
        $warranties = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.warranty.new.index', compact('warranties'));
    }

    // List all certificates for new warranties
    public function certificates()
    {
        $warranties = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.warranty.new.certificates', compact('warranties'));
    }

    // Get products for a new warranty via AJAX for the certificates modal
    public function getProductsAjax($id)
    {
        $warranty = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $html = view('user.warranty.new.partials.products_table', [
            'products' => $warranty->productDetails,
        ])->render();

        return response()->json([
            'title' => "Products for Warranty #{$warranty->invoice_number}",
            'html'  => $html,
        ]);
    }

    // Show single warranty
    public function show($id)
    {
        $warranty = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('user.warranty.new.show', compact('warranty'));
    }

    // Edit warranty (only for modify status)
    public function edit($id)
    {
        $warranty = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Check if warranty allows editing (has at least one modify product)
        $canEdit = $warranty->productDetails->where('status', 'modify')->count() > 0;

        if (!$canEdit) {
            return redirect()->route('user.warranties.index')->with('error', 'This warranty cannot be edited.');
        }

        $productTypes = ProductType::with('variants')->where('is_active', true)->get();

        return view('user.warranty.new.edit', [
            "pageTitle"       => "Edit Warranty Registration",
            "pageDescription" => "Edit Warranty Registration",
            "pageScript"      => "editwarrantynew",
            "productTypes"    => $productTypes,
            "warranty"        => $warranty
        ]);
    }

    // Update warranty registration
    public function update(Request $request, $id)
    {
        $warranty = WarrantyRegistrationNew::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Validate request
        $this->validateWarrantyRequest($request, $id);

        try {
            // Update warranty details
            $updateData = [
                'dealer_name'    => $request->dealer_name,
                'dealer_state'   => $request->dealer_state,
                'dealer_city'    => $request->dealer_city,
                'invoice_number' => $request->invoice_number,
                'status'         => 'pending', // Reset status to pending after edit
                'admin_remarks'  => null,       // Clear admin remarks
            ];

            // Handle invoice file upload
            if ($request->hasFile('upload_invoice')) {
                $invoicePath = $request->file('upload_invoice')->store('warranty/invoices', 'public');
                $updateData['invoice_file_path'] = $invoicePath;
            }

            $warranty->update($updateData);

            // Process products
            $hasUpdates = false;
            foreach ($request->products as $index => $productData) {
                // We typically expect an ID for existing products
                if (isset($productData['id'])) {
                    $productDetail = ProductDetail::where('warranty_registration_id', $warranty->id)
                        ->where('id', $productData['id'])
                        ->first();

                    if ($productDetail && $productDetail->status === 'modify') {
                        // Only update if status is modify
                        $this->updateProductDetail($productDetail, $productData);
                        $hasUpdates = true;
                    }
                }
            }

            // If any product was updated, we might want to change the overall warranty status or product status
            // For now, let's assume individual product status changes are handled by admin,
            // but if user edits, maybe we switch it back to pending?
            // The requirement didn't specify, but usually 'modify' -> 'pending' after safe.
            // Let's update the modified products status to 'pending' so admin can review again.
             if ($hasUpdates) {
                foreach ($request->products as $productData) {
                     if (isset($productData['id'])) {
                        $productDetail = ProductDetail::where('warranty_registration_id', $warranty->id)
                            ->where('id', $productData['id'])
                            ->where('status', 'modify')
                            ->first();

                        if ($productDetail) {
                            $productDetail->update(['status' => 'pending']);
                        }
                     }
                }
                // Also update main warranty status if needed, or let the accessor handle it.
                // The accessor calculates based on product statuses.
             }

            return response()->json([
                'success' => true,
                'message' => 'Warranty registration updated successfully!',
            ]);

        } catch (\Exception $e) {
            \Log::error('Warranty Update Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating. Please try again.',
            ], 500);
        }
    }

    // Helper to update product detail
    private function updateProductDetail($productDetail, $data)
    {
        $productType = ProductType::find($data['product_type_id']);
        $config      = $this->productFieldConfig[$productType->name] ?? [];

        // Variant
        $variantValue = null;
        if (! empty($data['variant_id'])) {
            $variant      = ProductTypeVariant::find($data['variant_id']);
            $variantValue = $variant ? $variant->variant_name : null;
        } elseif (! empty($data['variant'])) {
            $variantValue = $data['variant'];
        }

        // Handover Certificate
        $handoverPath = $productDetail->handover_certificate;
        if (isset($data['handover_certificate']) && $data['handover_certificate']) {
            $handoverPath = $data['handover_certificate']->store('warranty/handover_certificates', 'public');
        }

        // UoM
        $uomValue = $data['uom'] ?? $productDetail->uom;
        if (isset($config['auto_fill']) && empty($uomValue)) {
            $uomValue = $config['auto_fill']['uom'] ?? null;
        }

        $productDetail->update([
            // 'product_type_id' => $data['product_type_id'], // Keep original product type? Or allow change? Assuming Keep for now as edit might be just fixing fields.
            // actually if they change product type in UI, we should update it.
            'product_type_id'          => $data['product_type_id'],
            'variant_id'               => $data['variant_id'] ?? null,
            'variant'                  => $variantValue,
            'product_name_design'      => $data['product_name_design'] ?? null,
            'product_category'         => $data['product_category'] ?? null,
            'no_of_boxes'              => $data['no_of_boxes'] ?? null,
            'quantity'                 => $data['quantity'] ?? null,
            'area_sqft'                => $data['area_sqft'] ?? null,
            'handover_certificate'     => $handoverPath,
            'invoice_number'           => $data['invoice_number'] ?? null,
            'invoice_date'             => $data['invoice_date'] ?? null,
            'uom'                      => $uomValue,
            'site_address'             => $data['site_address'] ?? null,
            'product_thickness'        => $data['product_thickness'] ?? null,
            'admin_remarks'            => null, // Clear remarks on update
        ]);
    }



    // Download warranty certificate
    public function downloadCertificate($id)
    {
        // $id is now the ProductDetail ID
        $productDetail = ProductDetail::with(['warrantyRegistration', 'warrantyRegistration.user', 'productType', 'variant'])
            ->findOrFail($id);

        // Check if the product belongs to the authenticated user
        if ($productDetail->warrantyRegistration->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if product is approved
        if ($productDetail->status !== 'approved') {
            return redirect()->back()->with('error', 'Certificate is only available for approved products.');
        }

        // Map ProductDetail and WarrantyRegistrationNew to what the view expects
        // The view expects $warrantyProduct and $warrantyProduct->registration

        // Remap new product type IDs to match what download.blade.php expects
        $typeMapping = [
            1 => 3, // Mikasa Ply
            2 => 4, // Greenlam Clads
            3 => 5, // MikasaFx
            4 => 6, // Greenlam Sturdo
            5 => 1, // Mikasa Floors
            6 => 2, // Mikasa Doors
        ];

        $mappedProductType = $typeMapping[$productDetail->product_type_id] ?? $productDetail->product_type_id;


        $warrantyProduct = (object)[
            'id' => $productDetail->id,
            'product_type' => $mappedProductType,
            'qty_purchased' => $productDetail->quantity,
            'total_quantity' => $productDetail->quantity,
            'variant_name' => $productDetail->variant,
            'product_name_design' => $productDetail->product_name_design,
            'site_address' => $productDetail->site_address,
            'project_location' => $productDetail->site_address,
            'invoice_number' => $productDetail->warrantyRegistration->invoice_number,
            'invoice_date' => $productDetail->warrantyRegistration->invoice_date ?: ($productDetail->invoice_date ?: null),
            'handover_certificate_date' => $productDetail->warrantyRegistration->invoice_date ?: ($productDetail->invoice_date ?: null),
            'branch_name' => 'N/A',
            'product_code' => $productDetail->product_name_design ?: 'N/A',
            'surface_treatment_type' => 'N/A',
            'product_thickness' => json_encode([['thickness' => $productDetail->product_thickness ?: 'N/A', 'quantity' => $productDetail->quantity]]),
            'warranty_years' => '10 yrs',
            'date_of_issuance' => $productDetail->updated_at,
            'execution_agency' => 'N/A',
            'registration' => (object)[
                'invoice_number' => $productDetail->warrantyRegistration->invoice_number,
                'dealer_name' => $productDetail->warrantyRegistration->dealer_name,
                'user' => $productDetail->warrantyRegistration->user
            ],
            'product' => (object)[
                'name' => $productDetail->productType->name
            ]
        ];

        // Some partials use specific product names to decide which template to show
        // We use product_name_design, then variant, then productType->name
        $productName = $productDetail->product_name_design ?: ($productDetail->variant ?: $productDetail->productType->name);

        // Special handling for Floors (Old ID 1) - templates expect specific names
        if ($mappedProductType == 1) {
            // If it's a known variant name, ensure it matches exactly what the partial expects
            if (stripos($productName, 'Atmos') !== false) {
                $productName = 'Atmos (10 mm)';
            } elseif (stripos($productName, 'Pristine') !== false) {
                $productName = 'Pristine (15 mm)';
            }
        }

        // Logo Logic matching WarrantyController
        $logoPath   = public_path('assets/images/greenlam-logo.png');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('assets/images/logo.png');
        }
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logo       = 'data:image/png;base64,' . $logoBase64;

        $greenlamCladsLogoPath = public_path('assets/images/Greenlam-clads-logo.jpg');
        if ($mappedProductType == 4) { //clads
            $greenlamCladsLogoPath = public_path('assets/images/Greenlam-clads-logo.jpg');
        } else if ($mappedProductType == 6) { //sturdo
            $greenlamCladsLogoPath = public_path('assets/images/greenlam-sturdo.jpg');
        }

        if (file_exists($greenlamCladsLogoPath)) {
            $greenlamCladsLogoBase64 = base64_encode(file_get_contents($greenlamCladsLogoPath));
            $greenlamCladsLogo       = 'data:image/jpg;base64,' . $greenlamCladsLogoBase64;
        } else {
            $greenlamCladsLogo = asset('assets/images/greenlam-clads-logo.png');
        }

        return view('warranty.download', [
            "pageTitle"         => "Download Warranty Certificate",
            "pageDescription"   => "Download Warranty Certificates",
            "pageScript"        => "warranty",
            "warrantyProduct"   => $warrantyProduct,
            "logo"              => $logo,
            "greenlamCladsLogo" => $greenlamCladsLogo,
            "productName"       => $productName
        ]);
    }

// ----------------------------------------------------------------



}
