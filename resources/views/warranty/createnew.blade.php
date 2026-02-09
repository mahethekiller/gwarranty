<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <label for="builder_contractor" class="form-label custom-form-label">
                    Select Yes if you bought the product yourself. Select No if you purchased it through a builder or contractor.
                </label>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv1(true)" class="form-check-input" type="radio"
                                   name="radio" id="radio-1" value="1" required>
                            <label class="form-check-label" for="radio-1"> Yes </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv2(true)" class="form-check-input" type="radio"
                                   name="radio" id="radio-2" value="0" required>
                            <label class="form-check-label" for="radio-2"> No </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Self Purchase Form --}}
    <div class="col-md-12 col-xl-12" id="targetDiv1" style="display: none;">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.warranty.new.store') }}" id="warrantyFormNew" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dealer Information --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_name" class="form-label custom-form-label">Dealer Name *</label>
                                <input class="form-control" id="dealer_name" type="text" name="dealer_name" required>
                                <span class="text-danger" id="error-dealer_name"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_state" class="form-label custom-form-label">Dealer State *</label>
                                <select class="form-control" id="dealer_state" name="dealer_state" required>
                                    <option value="">Select State</option>
                                    @foreach (config('constants.states') as $state)
                                        <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error-dealer_state"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_city" class="form-label custom-form-label">Dealer City *</label>
                                <select class="form-control" id="dealer_city" name="dealer_city" required>
                                    <option value="">Select City</option>
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
                                <input class="form-control" id="invoice_number" type="text" name="invoice_number" required>
                                <span class="text-danger" id="error-invoice_number"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="upload_invoice" class="form-label custom-form-label">Upload Invoice *</label>
                                <input class="form-control" type="file" id="upload_invoice" name="upload_invoice" required>
                                <small class="text-info">.jpg, .png, .pdf, .doc, .docx. Max size: 2MB</small>
                                <span class="text-danger" id="error-upload_invoice"></span>
                                <div id="upload_invoice_preview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Products Section --}}
                    <h5 class="mb-3">Product Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="productsTable">
                            <tbody id="productsTableBody">
                                <tr class="product-row" data-index="0">
                                    {{-- Product Type --}}
                                    <td width="15%" class="product-type-label">
                                        <label class="form-label mb-1" style="font-size: 12px;">Product Type *</label>
                                        <select class="form-select product-type" name="products[0][product_type_id]" required>
                                            <option value="">Select Product Type</option>
                                            @foreach($productTypes as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- Variant --}}
                                    <td width="12%" class="variant-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Variant</label>
                                        <select class="form-select variant-select" name="products[0][variant_id]">
                                            <option value="">Select Variant</option>
                                        </select>
                                        <input type="text" class="form-control variant-input mt-1"
                                               name="products[0][variant]" placeholder="Enter variant" style="display: none;">
                                    </td>

                                    {{-- Product Name/Design --}}
                                    <td width="12%" class="product-name-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Product Name/Design</label>
                                        <input type="text" class="form-control product-name-input"
                                               name="products[0][product_name_design]" placeholder="Enter product name/design">
                                    </td>

                                    {{-- Product Category --}}
                                    <td width="10%" class="product-category-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Product Category</label>
                                        <input type="text" class="form-control product-category-input"
                                               name="products[0][product_category]" placeholder="Enter category">
                                    </td>

                                    {{-- No. of Boxes --}}
                                    <td width="8%" class="boxes-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">No. of Boxes</label>
                                        <input type="number" class="form-control boxes-input"
                                               name="products[0][no_of_boxes]" placeholder="Boxes" min="0">
                                    </td>

                                    {{-- Quantity --}}
                                    <td width="8%" class="quantity-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Quantity</label>
                                        <input type="number" class="form-control quantity-input"
                                               name="products[0][quantity]" placeholder="Qty" min="0">
                                    </td>

                                    {{-- Area (Sq. Ft.) --}}
                                    <td width="8%" class="area-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Area (Sq. Ft.)</label>
                                        <input type="number" class="form-control area-input"
                                               name="products[0][area_sqft]" placeholder="Area" step="0.01" min="0">
                                    </td>

                                    {{-- Handover Certificate --}}
                                    <td width="12%" class="handover-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Handover Certificate</label>
                                        <input type="file" class="form-control handover-input"
                                               name="products[0][handover_certificate]">
                                        <small class="text-info d-block" style="font-size: 10px;">Max: 2MB</small>
                                        <div class="handover-preview mt-1"></div>
                                    </td>

                                    {{-- Invoice No. --}}
                                    <td width="10%" class="invoice-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Invoice No.</label>
                                        <input type="text" class="form-control product-invoice-input"
                                               name="products[0][invoice_number]" placeholder="Invoice no.">
                                    </td>

                                    {{-- Invoice Date --}}
                                    <td width="10%" class="invoice-date-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Invoice Date</label>
                                        <input type="date" class="form-control invoice-date-input"
                                               name="products[0][invoice_date]">
                                    </td>

                                    {{-- UoM --}}
                                    <td width="8%" class="uom-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">UoM</label>
                                        <input type="text" class="form-control uom-input"
                                               name="products[0][uom]" placeholder="UoM" readonly>
                                    </td>

                                    {{-- Site Address --}}
                                    <td width="12%" class="site-address-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Site Address</label>
                                        <textarea class="form-control site-address-input"
                                                  name="products[0][site_address]" placeholder="Site address" rows="2"></textarea>
                                    </td>

                                    {{-- Product Thickness --}}
                                    <td width="10%" class="thickness-col" style="display: none;">
                                        <label class="form-label mb-1" style="font-size: 12px;">Product Thickness</label>
                                        <input type="text" class="form-control thickness-input"
                                               name="products[0][product_thickness]" placeholder="Thickness">
                                    </td>

                                    {{-- Action --}}
                                    <td width="5%" style="vertical-align: bottom;">
                                        <button type="button" class="btn btn-danger btn-sm remove-product-row" style="display: none;">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success btn-sm" id="addProductRow" style="display: none;">
                                Add Product
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="alert alert-danger d-none" id="formErrors"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary">
                                 Submit Warranty Registration
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Builder/Contractor Message --}}
    <div class="col-md-12 col-xl-12" id="targetDiv2" style="display: none;">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="mb-0">"Please contact the builder/contractor for warranty"​</h6>
                </div>
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

        .handover-preview a {
            font-size: 11px;
            padding: 2px 6px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 3px;
            display: block;
        }

        .remove-product-row {
            padding: 4px 8px;
            font-size: 12px;
            margin-top: 5px;
        }

        #addProductRow {
            margin-bottom: 15px;
        }

        /* Make table responsive on mobile */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            #productsTable {
                min-width: 1200px;
            }
        }


        <style>
/* Error message styling */
#formErrors {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

#formErrors.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

#formErrors.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

#formErrors ul {
    margin-bottom: 0;
    padding-left: 20px;
}

#formErrors li {
    margin-bottom: 5px;
}

/* Highlight error fields */
.has-error {
    border-color: #dc3545 !important;
}

.error-field {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

/* Make the error message more noticeable */
#formErrors:not(.d-none) {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

/* Form validation styling */
.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + .75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
    background-size: calc(.75em + .375rem) calc(.75em + .375rem);
}

.form-control.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
</style>

    </style>
</x-userdashboard-layout>
