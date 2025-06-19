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
                                                <th>Product Tpye</th>
                                                <th>Quantity</th>
                                                <th>Application Type</th>
                                                <th>Place of Purchase</th>
                                                <th>Invoice Number</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warranties as $warranty)
                                                <tr>
                                                    <td>{{ $warranty->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $warranty->product_type }}</td>
                                                    <td>{{ $warranty->qty_purchased }}</td>
                                                    <td>{{ $warranty->application }}</td>
                                                    <td>{{ $warranty->place_of_purchase }}</td>
                                                    <td>{{ $warranty->invoice_number }}</td>
                                                    <td>
                                                        @if ($warranty->status == 'modify')
                                                            <a data-bs-toggle="modal" data-bs-target="#editWarrantyModel"
                                                                href="#"
                                                                class="badge bg-light-warning border border-warning"><i
                                                                    class="fa fa-edit"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($warranty->status == 'pending')
                                                            <span
                                                                class="badge bg-light-danger border border-danger">Pending</span>
                                                        @elseif($warranty->status == 'approved')
                                                            <span
                                                                class="badge bg-light-success border border-success">Approved</span>
                                                        @elseif($warranty->status == 'modify')
                                                            <span
                                                                class="badge bg-light-warning border border-warning">Modify</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach





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


    <div class="modal fade" id="editWarrantyModel" tabindex="-1" aria-labelledby="editWarrantyModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="editWarrantyModelLabel">Modify Warranty Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="product_tpye" class="form-label custom-form-label">Product Tpye</label>
                                    <select class="form-select" id="mySelect">
                                        <option selected="">Select Product Type</option>
                                        <option value="1">Mikasa Floors</option>
                                        <option value="mikasa_doors">Mikasa Doors</option>
                                        <option value="3">Mikasa Ply</option>
                                        <option value="4">Greenlam Clads</option>
                                        <option value="5">NewMikaFx</option>
                                        <option value="6">Greenlam Sturdo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="qty_purchased" class="form-label custom-form-label">Qty</label>
                                    <input class="form-control" id="qty_purchased" type="text"
                                        placeholder="Enter Qty Purchased">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="application_commercial_residential"
                                        class="form-label custom-form-label">Application Type</label>
                                    <select class="form-select" id="mySelect">
                                        <option selected="">Select Application Type</option>
                                        <option value="1">Commercial</option>
                                        <option value="2">Residential</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="place_of_purchase" class="form-label custom-form-label">Place of
                                        Purchase</label>
                                    <input class="form-control" id="place_of_purchase" type="text"
                                        placeholder="Enter Place of Purchase">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="invoice_number" class="form-label custom-form-label">Invoice
                                        Number</label>
                                    <input class="form-control" id="invoice_number" type="text"
                                        placeholder="Enter Invoice Number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="upload_invoice" class="form-label custom-form-label">Upload
                                        Invoice</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="upload_handover_certificate" class="form-label custom-form-label">Upload
                                        Handover Certificate</label>
                                    <input class="form-control" type="file" id="formFile">
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
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-userdashboard-layout>
