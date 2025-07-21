<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}




    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <label for="builder_contractor" class="form-label custom-form-label">Have you bought the product by
                    yourself or from any builder/ contractor?</label>
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
                                <label for="dealer_name" class="form-label custom-form-label">Dealer Name</label>
                                <input class="form-control" id="dealer_name" type="text" name="dealer_name"
                                    placeholder="Enter Dealer Name">
                                <span class="text-danger" id="error-dealer_name" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_state" class="form-label custom-form-label">Dealer State</label>
                                <select class="form-control" id="dealer_state" name="dealer_state">
                                    <option value="">Select State</option>
                                    @foreach (config('constants.states') as $state)
                                        <option value="{{ $state }}">
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error-dealer_state"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dealer_city" class="form-label custom-form-label">Dealer City</label>
                                <select class="form-control" id="dealer_city" name="dealer_city">
                                    <option value="">Select City</option>

                                </select>
                                <span class="text-danger" id="error-dealer_city"></span>
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
                                <input class="form-control" type="file" id="upload_invoice" name="upload_invoice">
                                <span class="text-info" role="alert">
                                    <small>.jpg, .png, .pdf, .doc, .docx. Max size: 2MB</small>
                                </span>
                                <br>
                                <span class="text-danger" style="font-size: 12px;" id="error-upload_invoice"
                                    role="alert">
                                    <strong></strong>
                                </span>

                                <div id="upload_invoice_preview" class="upload_invoice_preview"></div>
                            </div>
                        </div>


                    </div>

                    <div class="form-group row">
                        <table id="tableBody" class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="product_type">Product Type</label>
                                        <select class="form-select" id="product_type" name="product_type[]">
                                            <option value="" selected>Select Product Type</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="error-product_type" role="alert">
                                            <strong></strong>
                                        </span>
                                    </td>
                                    <td>
                                        <label for="qty_purchased">Quantity Purchased</label>
                                        <input class="form-control" id="qty_purchased" type="text"
                                            name="qty_purchased[]" placeholder="Enter Qty Purchased">
                                        <span class="text-danger" id="error-qty_purchased" role="alert">
                                            <strong></strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="application-wrapper">
                                            <label for="application">Application Type</label>
                                            <select class="form-select" id="application" name="application[]">
                                                <option value="" selected>Select Application Type</option>
                                                <option value="Commercial">Commercial</option>
                                                <option value="Residential">Residential</option>
                                            </select>
                                            <span class="text-danger" id="error-application" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="handover-wrapper">
                                            <label for="handover_certificate">Upload Handover Certificate</label>
                                            <input class="form-control" type="file" id="handover_certificate"
                                                name="handover_certificate[]">
                                            <span class="text-info" role="alert">
                                                <small>.jpg, .png, .pdf, .doc, .docx. Max size: 2MB</small>
                                            </span>
                                            <div id="handover_certificate_preview" class="upload_invoice_preview">
                                            </div>
                                            <span class="text-danger" style="font-size: 12px;"
                                                id="error-handover_certificate" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <label>&nbsp;</label><br>
                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                        <button type="button" class="btn btn-sm btn-success " id="addNewRow">Add New</button>
                            </div>
                        </div>


                    </div>

                    <div class="form-group row">
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




        {{-- <div class="card">
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
        </div> --}}
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
