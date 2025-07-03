<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}




    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <label for="builder_contractor" class="form-label custom-form-label">Bought it for
                    yourself (Builder/Contractor?)</label>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv1(true)" class="form-check-input" type="radio" name="radio"
                                id="radio-1" required>
                            <label class="form-check-label" for="radio-1"> Yes </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv2(true)" class="form-check-input" type="radio" name="radio"
                                id="radio-2" required>
                            <label class="form-check-label" for="radio-2"> No </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-12" id="targetDiv1" style="display: none;">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.warranty.store') }}" id="warrantyForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="product_type" class="form-label custom-form-label">Product
                                    Type*</label>
                                <select class="form-select" id="product_type" name="product_type" >
                                    <option value="" selected>Select Product Type</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <span class="text-danger" id="login-error-phone_number"></span> --}}

                                <span class="text-danger" id="error-product_type" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="qty_purchased" class="form-label custom-form-label">Quantity
                                    Purchased*</label>
                                <input class="form-control" id="qty_purchased" type="text" name="qty_purchased"
                                    placeholder="Enter Qty Purchased">
                                <span class="text-danger" id="error-qty_purchased" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="application" class="form-label custom-form-label">Application
                                    Type</label>

                                <select class="form-select" id="application" name="application">
                                    <option selected>Select Product Type</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Residential">Residential</option>

                                </select>
                                <span class="text-danger" id="error-application" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="place_of_purchase" class="form-label custom-form-label">Place
                                    of Purchase*</label>
                                <input class="form-control" id="place_of_purchase" type="text"
                                    name="place_of_purchase" placeholder="Enter Place of Purchase">
                                <span class="text-danger" id="error-place_of_purchase" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="invoice_number" class="form-label custom-form-label">Invoice
                                    Number*</label>
                                <input class="form-control" id="invoice_number" type="text" name="invoice_number"
                                    placeholder="Enter Invoice Number">
                                <span class="text-danger" id="error-invoice_number" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group position-relative">
                                <label for="upload_invoice" class="form-label custom-form-label">Upload
                                    Invoice* </label>
                                <input class="form-control" type="file" id="upload_invoice"
                                    name="upload_invoice">
                                <span class="text-info" role="alert">
                                    <small>.jpg, .png, .pdf, .doc, .docx. Max size: 2MB</small>
                                </span>
                                <br>
                                <span class="text-danger" style="font-size: 12px;" id="error-upload_invoice" role="alert">
                                    <strong></strong>
                                </span>

                                <div  id="upload_invoice_preview"  class="upload_invoice_preview"></div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="myDivMikasaDoors">
                            <div class="form-group position-relative">
                                <label for="handover_certificate" class="form-label custom-form-label">Upload
                                    Handover
                                    Certificate</label>
                                <input class="form-control" type="file" id="handover_certificate"
                                    name="handover_certificate">
                                <span class="text-info" role="alert">
                                    <small>.jpg, .png, .pdf, .doc, .docx. Max size: 2MB

                                    </small>
                                </span>
                                <br>

                                <div  id="handover_certificate_preview" class="upload_invoice_preview"></div>

                                <span class="text-danger" style="font-size: 12px;" id="error-handover_certificate" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button class="custom-btn-blk" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="col-md-12 col-xl-12" id="targetDiv2" style="display: none;">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <h6>“Please contact the builder/contractor for warranty”​</h6>
                </div>
            </div>
        </div>
    </div>
</x-userdashboard-layout>
