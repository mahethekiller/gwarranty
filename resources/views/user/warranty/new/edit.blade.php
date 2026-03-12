<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.warranty.new.update', $warranty->id) }}" id="warrantyFormEdit" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dealer Information --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_name" class="form-label custom-form-label">Dealer Name *</label>
                                <input class="form-control" id="dealer_name" type="text" name="dealer_name"
                                       value="{{ old('dealer_name', $warranty->dealer_name) }}" required>
                                <span class="text-danger" id="error-dealer_name"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_state" class="form-label custom-form-label">Dealer State *</label>
                                <select class="form-control" id="dealer_state" name="dealer_state" required>
                                    <option value="">Select State</option>
                                    @foreach (config('constants.states') as $state)
                                        <option value="{{ $state }}" {{ $warranty->dealer_state == $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error-dealer_state"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_city" class="form-label custom-form-label">Dealer City *</label>
                                <select class="form-control" id="dealer_city" name="dealer_city" required data-selected="{{ $warranty->dealer_city }}">
                                    <option value="">Select City</option>
                                    <option value="{{ $warranty->dealer_city }}" selected>{{ $warranty->dealer_city }}</option>
                                </select>
                                <span class="text-danger" id="error-dealer_city"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Invoice Information --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="invoice_number" class="form-label custom-form-label">Invoice Number *</label>
                                <input class="form-control" id="invoice_number" type="text" name="invoice_number"
                                       value="{{ old('invoice_number', $warranty->invoice_number) }}" required>
                                <span class="text-danger" id="error-invoice_number"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="invoice_date" class="form-label custom-form-label">Invoice Date *</label>
                                <input class="form-control" id="invoice_date" type="date" name="invoice_date"
                                       value="{{ old('invoice_date', $warranty->invoice_date ? $warranty->invoice_date->format('Y-m-d') : '') }}" required>
                                <span class="text-danger" id="error-invoice_date"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="upload_invoice" class="form-label custom-form-label">Upload Invoice</label>
                                <input class="form-control" type="file" id="upload_invoice" name="upload_invoice">
                                <small class="text-info">.jpg, .png, .pdf, .doc, .docx. Max size: 2MB</small>
                                <span class="text-danger" id="error-upload_invoice"></span>
                                <div id="upload_invoice_preview" class="mt-2">
                                     @if($warranty->invoice_file_path)
                                        <a href="{{ Storage::url($warranty->invoice_file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                            View Current Invoice
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Products Section --}}
                    <h5 class="mb-3">Product Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="productsTable">
                            <tbody id="productsTableBody">
                                @foreach($warranty->productDetails as $index => $product)
                                <tr class="product-row" data-index="{{ $index }}" data-status="{{ $product->status }}">
                                    @if($product->status === 'modify')
                                        <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                        {{-- EDITABLE ROW --}}

                                        {{-- Product Type --}}
                                        <td width="15%" class="product-type-label">
                                            <label class="form-label mb-1" style="font-size: 12px;">Product Type *</label>
                                            <select class="form-select product-type" name="products[{{ $index }}][product_type_id]" required>
                                                <option value="">Select Product Type</option>
                                                @foreach($productTypes as $type)
                                                    <option value="{{ $type->id }}" {{ $product->product_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($product->admin_remarks)
                                                <div class="text-danger mt-2" style="font-size: 11px;">
                                                    <strong>Admin Remarks:</strong> {{ $product->admin_remarks }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Variant --}}
                                        <td width="12%" class="variant-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Variant</label>
                                            <select class="form-select variant-select" name="products[{{ $index }}][variant_id]" data-selected="{{ $product->variant_id }}">
                                                <option value="">Select Variant</option>
                                            </select>
                                            <input type="text" class="form-control variant-input mt-1"
                                                   name="products[{{ $index }}][variant]" value="{{ $product->variant }}" placeholder="Enter variant" style="display: none;">
                                        </td>

                                        {{-- Product Name/Design --}}
                                        <td width="12%" class="product-name-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Product Name/Design</label>
                                            <input type="text" class="form-control product-name-input"
                                                   name="products[{{ $index }}][product_name_design]" value="{{ $product->product_name_design }}" placeholder="Enter product name/design">
                                        </td>

                                        {{-- Product Category --}}
                                        <td width="10%" class="product-category-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Product Category</label>
                                            <input type="text" class="form-control product-category-input"
                                                   name="products[{{ $index }}][product_category]" value="{{ $product->product_category }}" placeholder="Enter category">
                                        </td>

                                        {{-- No. of Boxes --}}
                                        <td width="8%" class="boxes-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">No. of Boxes</label>
                                            <input type="number" class="form-control boxes-input"
                                                   name="products[{{ $index }}][no_of_boxes]" value="{{ $product->no_of_boxes }}" placeholder="Boxes" min="0">
                                        </td>

                                        {{-- Quantity --}}
                                        <td width="8%" class="quantity-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Quantity</label>
                                            <input type="number" class="form-control quantity-input"
                                                   name="products[{{ $index }}][quantity]" value="{{ $product->quantity }}" placeholder="Qty" min="0">
                                        </td>

                                        {{-- Area (Sq. Ft.) --}}
                                        <td width="8%" class="area-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Area (Sq. Ft.)</label>
                                            <input type="number" class="form-control area-input"
                                                   name="products[{{ $index }}][area_sqft]" value="{{ $product->area_sqft }}" placeholder="Area" step="0.01" min="0">
                                        </td>
                                        {{-- Product Thickness --}}
                                        <td width="10%" class="thickness-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Product Thickness</label>
                                            <input type="text" class="form-control thickness-input"
                                                   name="products[{{ $index }}][product_thickness]" value="{{ $product->product_thickness }}" placeholder="Thickness">
                                        </td>



                                        {{-- Invoice No. --}}
                                        <td width="10%" class="invoice-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Invoice No.</label>
                                            <input type="text" class="form-control product-invoice-input"
                                                   name="products[{{ $index }}][invoice_number]" value="{{ $product->invoice_number }}" placeholder="Invoice no.">
                                        </td>

                                        {{-- Invoice Date --}}
                                        <td width="10%" class="invoice-date-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Invoice Date</label>
                                            <input type="date" class="form-control invoice-date-input"
                                                   name="products[{{ $index }}][invoice_date]" value="{{ $product->invoice_date ? $product->invoice_date->format('Y-m-d') : '' }}">
                                        </td>

                                        {{-- UoM --}}
                                        <td width="8%" class="uom-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">UoM</label>
                                            <input type="text" class="form-control uom-input"
                                                   name="products[{{ $index }}][uom]" value="{{ $product->uom }}" placeholder="UoM" readonly>
                                        </td>
                                        {{-- Handover Certificate --}}
                                        <td width="12%" class="handover-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Handover Certificate</label>
                                            <input type="file" class="form-control handover-input"
                                                   name="products[{{ $index }}][handover_certificate]">
                                            <small class="text-info d-block" style="font-size: 10px;">Max: 2MB</small>
                                            <div class="handover-preview mt-1">
                                                @if($product->handover_certificate)
                                                    <a href="{{ Storage::url($product->handover_certificate) }}" target="_blank" class="btn btn-xs btn-info" style="font-size: 10px; padding: 2px 5px;">Current File</a>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Site Address --}}
                                        <td width="12%" class="site-address-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Site Address</label>
                                            <textarea class="form-control site-address-input"
                                                      name="products[{{ $index }}][site_address]" placeholder="Site address" rows="2">{{ $product->site_address }}</textarea>
                                        </td>

                                        {{-- Product Thickness --}}
                                        <td width="10%" class="thickness-col" style="display: none;">
                                            <label class="form-label mb-1" style="font-size: 12px;">Product Thickness</label>
                                            <input type="text" class="form-control thickness-input"
                                                   name="products[{{ $index }}][product_thickness]" value="{{ $product->product_thickness }}" placeholder="Thickness">
                                        </td>

                                    @else
                                        {{-- READ-ONLY ROW FOR NON-MODIFY PRODUCTS --}}
                                        <td colspan="12" class="bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $product->productType->name }}</strong>
                                                    @if($product->variant) - {{ $product->variant->variant_name ?? $product->variant }} @endif
                                                    <span class="badge {{ $product->status === 'approved' ? 'bg-success' : 'bg-warning' }} ms-2">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </div>
                                                <div class="text-muted small">
                                                    Quantity: {{ $product->quantity ?? $product->area_sqft ?? $product->no_of_boxes }} {{ $product->uom }}
                                                    <i class="fa fa-lock ms-2" title="This product cannot be edited"></i>
                                                </div>
                                            </div>
                                            @if($product->admin_remarks)
                                                <div class="mt-2 text-danger small">
                                                    <strong>Admin Remarks:</strong> {{ $product->admin_remarks }}
                                                </div>
                                            @endif
                                            {{-- Hidden logic handled by not including inputs for this row, backend ignores missing IDs or validates status --}}
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="alert alert-danger d-none" id="formErrors"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary">
                                 Update Warranty Registration
                            </button>
                            <a href="{{ route('user.warranties.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        #productsTable td {
            vertical-align: top;
            padding: 10px 5px;
        }

        #productsTable input, #productsTable select, #productsTable textarea {
            width: 100%;
        }

        #productsTable .form-control, #productsTable .form-select {
            font-size: 12px;
            padding: 5px;
            height: 32px;
        }

        #productsTable textarea.form-control {
            height: 60px;
            resize: vertical;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 3px;
            display: block;
        }
    </style>
</x-userdashboard-layout>
