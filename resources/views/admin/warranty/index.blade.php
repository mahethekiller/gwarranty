<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="col-md-12 col-xl-12">
                                <h4 class="pb-1">Warranty List</h4>
                                <div class="table-responsive">
                                    <table id="warrantyTable" class="table table-bordered table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Submitted Date</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>Application Type</th>
                                                <th>Place of Purchase</th>
                                                <th>Invoice Number</th>
                                                <th>Invoice</th>
                                                <th>Handover Certificate</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warranties as $key => $warranty)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $warranty->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $productNames[$warranty->product_type] ?? 'N/A' }}</td>
                                                    <td>{{ $warranty->qty_purchased }}</td>
                                                    <td>{{ $warranty->application }}</td>
                                                    <td>{{ $warranty->place_of_purchase }}</td>
                                                    <td>{{ $warranty->invoice_number }}</td>
                                                    <td>
                                                        @if ($warranty->invoice_path != null)
                                                            <a href="/storage/{{ $warranty->invoice_path }}"
                                                                target="_blank"
                                                                class="download-icon-red"><i
                                                                    class="fa fa-download"></i> &nbsp;View</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($warranty->handover_certificate_path != null)
                                                            <a href="/storage/{{ $warranty->handover_certificate_path }}"
                                                                target="_blank"
                                                                class="download-icon-red"><i
                                                                    class="fa fa-download"></i>&nbsp;View</a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($warranty->status == 'pending')
                                                            {{-- <span class="pending-icon-red"><i
                                                                    class="fa fa-clock-o"></i>&nbsp;&nbsp;Pending</span> --}}
                                                            <span class="badge bg-warning text-white">Pending</span>
                                                        @elseif($warranty->status == 'approved')
                                                            {{-- <span class="edit-icon-green"><i
                                                                    class="fa fa-check"></i>&nbsp;&nbsp;Approved</span> --}}
                                                            <span class="badge bg-success text-white">Approved</span>
                                                        @elseif($warranty->status == 'modify')
                                                            {{-- <span class="modify-icon-red"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Modify</span> --}}
                                                            <span class="badge bg-danger text-white">Modify</span>
                                                        @endif

                                                    </td>

                                                    <td>

                                                        <a data-bs-toggle="modal" data-bs-target="#editWarrantyModel"
                                                            href="#" data-id="{{ $warranty->id }}"
                                                            class="pending-icon-red"><i class="fa fa-pencil"></i>
                                                            &nbsp;Edit</a>
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





    <div class="modal fade" id="editWarrantyModel" tabindex="-1" aria-labelledby="editWarrantyModelLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="editWarrantyModelLabel">Edit Warranty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editWarrantyModelBody">

                </div>
            </div>
        </div>
    </div>

</x-userdashboard-layout>
