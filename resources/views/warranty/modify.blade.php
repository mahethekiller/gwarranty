<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped p-0">
                                        <thead>
                                            <tr>
                                                <th>Submited Date</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>Application Type</th>
                                                <th>Place of Purchase</th>
                                                <th>Invoice Number</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($warranties) == 0)
                                                <tr>
                                                    <td colspan="9" class="text-center">No data available</td>
                                                </tr>
                                            @else
                                                @foreach ($warranties as $warranty)
                                                    <tr>
                                                        <td>{{ $warranty->created_at->format('d-m-Y') }}</td>
                                                        <td>{{ $productNames[$warranty->product_type] ?? 'N/A' }}</td>
                                                        <td>{{ $warranty->qty_purchased }}</td>
                                                        <td>{{ $warranty->application }}</td>
                                                        <td>{{ $warranty->place_of_purchase }}</td>
                                                        <td>{{ $warranty->invoice_number }}</td>
                                                        <td>{{ $warranty->remarks }}</td>

                                                        <td>
                                                            @if ($warranty->status == 'modify')
                                                                <a data-bs-toggle="modal" data-bs-target="#editWarrantyModel"
                                                                    href="#" data-id="{{ $warranty->id }}"
                                                                    class="edit-icon-green"><i
                                                                        class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($warranty->status == 'pending')
                                                                <span class="pending-icon-red"><i
                                                                        class="fa fa-clock-o"></i>&nbsp;&nbsp;Pending</span>
                                                            @elseif($warranty->status == 'approved')
                                                                <span class="edit-icon-green"><i
                                                                        class="fa fa-check"></i>&nbsp;&nbsp;Approved</span>
                                                            @elseif($warranty->status == 'modify')
                                                                <span class="modify-icon-red"><i
                                                                        class="fa fa-pencil"></i>&nbsp;&nbsp;Modify</span>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif





                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editWarrantyModel" tabindex="-1" aria-labelledby="editWarrantyModelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="editWarrantyModelLabel">Modify Warranty Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editWarrantyModelBody">
                    {{-- <form action="" id="editWarrantyForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="product_type" class="form-label custom-form-label">Product Type</label>
                                    <select class="form-select" id="product_type" name="product_type">
                                        <option value="" selected="">Select Product Type</option>
                                        <option value="Mikasa Floors">Mikasa Floors</option>
                                        <option value="Mikasa Doors">Mikasa Doors</option>
                                        <option value="Mikasa Ply">Mikasa Ply</option>
                                        <option value="Greenlam Clads">Greenlam Clads</option>
                                        <option value="NewMikaFx">NewMikaFx</option>
                                        <option value="Greenlam Sturdo">Greenlam Sturdo</option>
                                    </select>
                                    <span class="text-danger" id="error-product_type" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="qty_purchased" class="form-label custom-form-label">Qty</label>
                                    <input class="form-control" id="qty_purchased" name="qty_purchased" type="text"
                                        placeholder="Enter Qty Purchased">
                                        <span class="text-danger" id="error-qty_purchased" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="application" class="form-label custom-form-label">Application Type</label>
                                    <select class="form-select" id="application" name="application">
                                        <option selected="">Select Application Type</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Residential">Residential</option>
                                    </select>
                                    <span class="text-danger" id="error-application" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="place_of_purchase" class="form-label custom-form-label">Place of
                                        Purchase</label>
                                    <input class="form-control" id="place_of_purchase" name="place_of_purchase" type="text"
                                        placeholder="Enter Place of Purchase">
                                        <span class="text-danger" id="error-place_of_purchase" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="invoice_number" class="form-label custom-form-label">Invoice
                                        Number</label>
                                    <input class="form-control" id="invoice_number" name="invoice_number" type="text"
                                        placeholder="Enter Invoice Number">
                                        <span class="text-danger" id="error-invoice_number" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="upload_invoice" class="form-label custom-form-label">Upload
                                        Invoice</label>
                                    <input class="form-control" type="file" id="upload_invoice" name="upload_invoice">
                                    <div id="invoice_preview"></div>
                                    <span class="text-danger" id="error-upload_invoice" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="upload_handover_certificate" class="form-label custom-form-label">Upload
                                        Handover Certificate</label>
                                    <input class="form-control" type="file" id="upload_handover_certificate" name="upload_handover_certificate">
                                    <div id="handover_certificate_preview"></div>
                                    <span class="text-danger" id="error-handover_certificate" role="alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button class="custom-btn-blk">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>


</x-userdashboard-layout>
