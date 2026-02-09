<x-userdashboard-layout :pageTitle="'Edit Warranty'" :pageDescription="'Edit warranty registration'" :pageScript="'editwarrantynew'">
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/warranty-edit.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-edit"></i> Edit Products Requiring Modification
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            Only products with "Modify Required" status can be edited. Please update the fields as requested by admin.
                        </div>

                        @if($warrantyRegistration->modifiableProductsCount > 0)
                            <form id="editProductsForm" method="POST" action="{{ route('user.warranty.update.modify', $warrantyRegistration->id) }}">
                                @csrf
                                @method('POST')

                                <!-- Registration Details -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fa fa-file-text-o"></i> Registration Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Dealer Name</label>
                                                    <input type="text" class="form-control"
                                                           value="{{ $warrantyRegistration->dealer_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Invoice Number</label>
                                                    <input type="text" class="form-control"
                                                           value="{{ $warrantyRegistration->invoice_number }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Products Section -->
                                <div class="mb-4">
                                    <h4 class="mb-3">
                                        <i class="fa fa-cubes"></i> Products to Modify ({{ $warrantyRegistration->modifiableProductsCount }})
                                    </h4>

                                    @foreach($warrantyRegistration->productDetails->where('status', 'modify') as $product)
                                        <div class="product-card" id="product-card-{{ $product->id }}">
                                            <div class="product-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0">
                                                        Product #{{ $loop->iteration }}
                                                        <span class="badge bg-primary ms-2">Modify Required</span>
                                                    </h5>
                                                    <div>
                                                        @if($product->admin_remarks)
                                                            <button type="button" class="btn btn-sm btn-outline-info admin-remarks-btn"
                                                                    data-remarks="{{ $product->admin_remarks }}">
                                                                <i class="fa fa-comment"></i> View Admin Remarks
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-body">
                                                <input type="hidden" name="products[{{ $product->id }}][product_type_id]"
                                                       value="{{ $product->product_type_id }}">

                                                <div class="row">
                                                    <!-- Product Type -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label required-field">Product Type</label>
                                                            <select class="form-select product-type-select"
                                                                    name="products[{{ $product->id }}][product_type_id]"
                                                                    data-product-id="{{ $product->id }}"
                                                                    disabled>
                                                                <option value="">Select Product Type</option>
                                                                @foreach($productTypes as $type)
                                                                    <option value="{{ $type->id }}"
                                                                            {{ $product->product_type_id == $type->id ? 'selected' : '' }}>
                                                                        {{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Variant -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3 variant-field"
                                                             data-product-id="{{ $product->id }}"
                                                             style="{{ $product->product_type_id ? '' : 'display:none;' }}">
                                                            <label class="form-label required-field">Variant</label>
                                                            <select class="form-select variant-select"
                                                                    name="products[{{ $product->id }}][variant]"
                                                                    data-product-id="{{ $product->id }}">
                                                                <option value="">Select Variant</option>
                                                                @if($product->variant_id)
                                                                    @php
                                                                        $variant = \App\Models\ProductTypeVariant::find($product->variant_id);
                                                                    @endphp
                                                                    @if($variant)
                                                                        <option value="{{ $variant->variant_name }}" selected>
                                                                            {{ $variant->variant_name }}
                                                                        </option>
                                                                    @endif
                                                                @elseif($product->variant)
                                                                    <option value="{{ $product->variant }}" selected>
                                                                        {{ $product->variant }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Dynamic Fields based on Product Type -->
                                                <div class="dynamic-fields" data-product-id="{{ $product->id }}">
                                                    @php
                                                        $productType = \App\Models\ProductType::find($product->product_type_id);
                                                        $config = $controller->productFieldConfig[$productType->name] ?? [];
                                                    @endphp

                                                    @if(!empty($config['fields']))
                                                        <div class="row">
                                                            @foreach($config['fields'] as $field)
                                                                @if($field !== 'variant')
                                                                    <div class="col-md-6 mb-3">
                                                                        @php
                                                                            $label = str_replace('_', ' ', ucfirst($field));
                                                                            $isRequired = in_array($field, $config['required'] ?? []);
                                                                            $fieldValue = $product->{$field} ?? '';
                                                                        @endphp

                                                                        <label class="form-label {{ $isRequired ? 'required-field' : '' }}">
                                                                            {{ $label }}
                                                                        </label>

                                                                        @if($field === 'product_category')
                                                                            <select class="form-control"
                                                                                    name="products[{{ $product->id }}][{{ $field }}]"
                                                                                    {{ $isRequired ? 'required' : '' }}>
                                                                                <option value="">Select Category</option>
                                                                                <option value="Interior" {{ $fieldValue == 'Interior' ? 'selected' : '' }}>Interior</option>
                                                                                <option value="Exterior" {{ $fieldValue == 'Exterior' ? 'selected' : '' }}>Exterior</option>
                                                                            </select>
                                                                        @elseif($field === 'handover_certificate')
                                                                            <select class="form-control"
                                                                                    name="products[{{ $product->id }}][{{ $field }}]"
                                                                                    {{ $isRequired ? 'required' : '' }}>
                                                                                <option value="">Select</option>
                                                                                <option value="Yes" {{ $fieldValue == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                                                <option value="No" {{ $fieldValue == 'No' ? 'selected' : '' }}>No</option>
                                                                            </select>
                                                                        @else
                                                                            <input type="{{ in_array($field, ['area_sqft', 'quantity']) ? 'number' : 'text' }}"
                                                                                   class="form-control"
                                                                                   name="products[{{ $product->id }}][{{ $field }}]"
                                                                                   value="{{ $fieldValue }}"
                                                                                   step="{{ $field === 'area_sqft' ? '0.01' : '1' }}"
                                                                                   {{ $isRequired ? 'required' : '' }}>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- UOM Field -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Unit of Measurement</label>
                                                            <input type="text" class="form-control uom-field"
                                                                   name="products[{{ $product->id }}][uom]"
                                                                   value="{{ $product->uom }}"
                                                                   readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.warranty.show', $warrantyRegistration->id) }}"
                                       class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back to Details
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fa fa-check"></i> Submit Updates
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i>
                                All products have been updated. No products require modification.
                            </div>
                            <a href="{{ route('user.warranty.show', $warrantyRegistration->id) }}"
                               class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Back to Details
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary loading-spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <style>
        /* warranty-edit.css */
.product-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 20px;
    transition: all 0.3s;
}
.product-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.product-header {
    background-color: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
}
.product-body {
    padding: 20px;
}
.required-field::after {
    content: " *";
    color: #dc3545;
}
.form-control:disabled,
.form-select:disabled {
    background-color: #e9ecef;
}
.loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}
.loading-spinner {
    width: 50px;
    height: 50px;
}
.border-danger {
    border-color: #dc3545 !important;
    border-width: 2px !important;
}
.admin-remarks-popover {
    max-width: 300px;
    word-wrap: break-word;
}
    </style>

    @push('scripts')

    <script>
        // Pass route URLs to JavaScript
        window.warrantyRoutes = {
            getVariants: '{{ route("user.warranty.getVariants", ["productTypeId" => ":productTypeId"]) }}',
            getProductFields: '{{ route("user.warranty.getProductFields", ["productTypeId" => ":productTypeId"]) }}'
        };
    </script>
    @endpush
</x-userdashboard-layout>
