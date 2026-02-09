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
            'upload_invoice'             => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'products'                   => 'required|array|min:1',
            'products.*.product_type_id' => 'required|exists:product_types,id',
        ];

        // Exclude current warranty from unique check for updates
        if ($excludeWarrantyId) {
            $rules['invoice_number'] = 'required|string|unique:warranty_registrations_new,invoice_number,' . $excludeWarrantyId;
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
    // public function getProductFields($productTypeId)
    // {
    //     $productType = ProductType::findOrFail($productTypeId);

    //     $config = $this->productFieldConfig[$productType->name] ?? [
    //         'required'  => [],
    //         'fields'    => [],
    //         'auto_fill' => [],
    //     ];

    //     return response()->json([
    //         'fields'            => $config['fields'],
    //         'required'          => $config['required'],
    //         'auto_fill'         => $config['auto_fill'],
    //         'product_type_name' => $productType->name,
    //     ]);
    // }

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

    // Show single warranty
    public function show($id)
    {
        $warranty = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('user.warranty.new.show', compact('warranty'));
    }

    // Edit warranty (only if status is 'modify')
    public function edit($id)
    {
        $warranty = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Check if warranty has any modifiable products
        if (! $warranty->can_be_edited) {
            return redirect()->route('user.warranty.show', $warranty->id)
                ->with('error', 'No products require modification. This warranty cannot be edited.');
        }

        $productTypes = ProductType::with('variants')->where('is_active', true)->get();

        return view(
            'user.warranty.new.edit',

            [
                "pageTitle"       => "Warranty Registration",
                "pageDescription" => "Warranty Registration",
                'warranty'        => $warranty,
                'productTypes'    => $productTypes,
                "pageScript"      => "editwarrantynew",
            ]
        );
    }

    // Download warranty certificate
    public function downloadCertificate($id)
    {
        $warranty = WarrantyRegistrationNew::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Check if warranty is approved
        if ($warranty->status !== 'approved') {
            return redirect()->back()->with('error', 'Certificate is only available for approved warranties.');
        }

        // Generate PDF certificate (you'll need to implement this)
        // For now, return a success message
        return redirect()->back()->with('success', 'Certificate download initiated.');
    }

// ----------------------------------------------------------------

/**
 * Show edit form for modify products
 */
    public function editModifyProducts($id)
    {
        $user = Auth::user();

        // Get warranty registration
        $warrantyRegistration = WarrantyRegistrationNew::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['productDetails' => function ($query) {
                $query->where('status', 'modify');
            }])
            ->firstOrFail();

        // Get product types for dropdown
        $productTypes = ProductType::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('user.warranty.new.edit', compact('warrantyRegistration', 'productTypes'));
    }

/**
 * Update modify products via AJAX
 */
    public function updateModifyProducts(Request $request, $id)
    {
        try {
            $user = Auth::user();

            // Validate registration belongs to user
            $warrantyRegistration = WarrantyRegistrationNew::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Get all modify products for this registration
            $modifyProducts = ProductDetail::where('warranty_registration_id', $id)
                ->where('status', 'modify')
                ->get();

            $updatedProducts = [];
            $errors          = [];

            // Process each product
            foreach ($modifyProducts as $product) {
                $productId   = $product->id;
                $productData = $request->input("products.{$productId}", []);

                // Get product type name for validation
                $productType     = ProductType::find($product->product_type_id);
                $productTypeName = $productType ? $productType->name : '';

                // Get field configuration
                $fieldConfig = $this->productFieldConfig[$productTypeName] ?? [];

                // Build validation rules
                $rules = [];
                if (! empty($fieldConfig['required'])) {
                    foreach ($fieldConfig['required'] as $field) {
                        $rules["products.{$productId}.{$field}"] = 'required';
                    }
                }

                // Validate required fields
                if (! empty($rules)) {
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $errors[$productId] = $validator->errors()->all();
                        continue;
                    }
                }

                // Prepare update data
                $updateData = [
                    'variant'              => $productData['variant'] ?? $product->variant,
                    'product_name_design'  => $productData['product_name_design'] ?? $product->product_name_design,
                    'product_category'     => $productData['product_category'] ?? $product->product_category,
                    'no_of_boxes'          => $productData['no_of_boxes'] ?? $product->no_of_boxes,
                    'quantity'             => $productData['quantity'] ?? $product->quantity,
                    'area_sqft'            => $productData['area_sqft'] ?? $product->area_sqft,
                    'handover_certificate' => $productData['handover_certificate'] ?? $product->handover_certificate,
                    'product_thickness'    => $productData['product_thickness'] ?? $product->product_thickness,
                    'site_address'         => $productData['site_address'] ?? $product->site_address,
                    'admin_remarks'        => null,      // Clear admin remarks after edit
                    'status'               => 'pending', // Reset status to pending
                ];

                // Update product
                $product->update($updateData);
                $updatedProducts[] = $productId;
            }

            if (! empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some products failed validation',
                    'errors'  => $errors,
                ], 422);
            }

            // Update registration status if all modify products are updated
            $remainingModifyProducts = ProductDetail::where('warranty_registration_id', $id)
                ->where('status', 'modify')
                ->count();

            if ($remainingModifyProducts === 0) {
                $warrantyRegistration->update([
                    'admin_remarks' => null,
                    'status'        => 'pending',
                ]);
            }

            return response()->json([
                'success'      => true,
                'message'      => 'Products updated successfully',
                'redirect_url' => route('user.warranty.show', $id),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating products: ' . $e->getMessage(),
            ], 500);
        }
    }

/**
 * Get field configuration for product type via AJAX
 */
    public function getProductFields($productTypeId)
    {
        try {
            $productType = ProductType::find($productTypeId);
            if (! $productType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product type not found',
                ], 404);
            }

            $config = $this->productFieldConfig[$productType->name] ?? [
                'required'  => [],
                'fields'    => [],
                'auto_fill' => [],
            ];

            return response()->json([
                'success'           => true,
                'config'            => $config,
                'product_type_name' => $productType->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching field configuration',
            ], 500);
        }
    }

}
