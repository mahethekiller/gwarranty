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
                                                <th>Dealer</th>
                                                <th>Dealer State & City</th>
                                                <th>Invoice Number</th>
                                                <th>Invoice</th>
                                                {{-- <th>Remarks</th> --}}
                                                <th>Products Status</th>
                                                {{-- <th>Status</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warranties as $key => $warranty)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $warranty->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $warranty->dealer_name ?? 'N/A' }}</td>
                                                    <td>{{ $warranty->dealer_state ?? '--' }} > {{ $warranty->dealer_city ?? '--' }}</td>
                                                    <td>{{ $warranty->invoice_number }}</td>
                                                    <td>
                                                        @if ($warranty->upload_invoice)
                                                            <a href="/storage/{{ $warranty->upload_invoice }}"
                                                                target="_blank" class="download-icon-red">
                                                                <i class="fa fa-download"></i>&nbsp;View
                                                            </a>
                                                        @endif
                                                    </td>
                                                    {{-- <td>{{ $warranty->remarks ?? 'N/A' }}</td> --}}
                                                    <td>


                                                        @php
                                                            $products = $warranty->products->pluck('id')->toArray();
                                                            $allApproved = \App\Models\WarrantyProduct::whereIn('id', $products)->whereIn('product_type', $productIds)->where('product_status', '!=', 'approved')->doesntExist();
                                                        @endphp


                                                            <a href="#" class="view-icon-red view-products-btn {{ $allApproved ? 'bg-success' : '' }}"
                                                                data-products='@json($warranty->products)'
                                                                data-title="Products for Warranty #{{ $key + 1 }}">
                                                                <i class="fa fa-eye"></i> &nbsp; View
                                                            </a>

                                                    </td>
                                                    {{-- <td>
                                                        @if ($warranty->status == 'pending')
                                                            <span class="badge bg-warning text-white">Pending</span>
                                                        @elseif($warranty->status == 'approved')
                                                            <span class="badge bg-success text-white">Approved</span>
                                                        @elseif($warranty->status == 'modify')
                                                            <span class="badge bg-danger text-white">Modify</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>
                                                        <a data-bs-toggle="modal" data-bs-target="#editWarrantyModel"
                                                            href="#" data-id="{{ $warranty->id }}"
                                                            class="pending-icon-red">
                                                            <i class="fa fa-pencil"></i>&nbsp;Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Products Modal -->
                                    <div class="modal fade" id="productsModal" tabindex="-1"
                                        aria-labelledby="productsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="productsModalLabel">Products</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>Application Type</th>
                                                                <th>Handover Certificate</th>
                                                                <th>Remarks</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="productsModalBody">
                                                            <!-- Dynamically filled by JS -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Pagination links --}}
                                    <div class="mt-3">
                                        {{-- {{ $warranties->links() }} --}}
                                    </div>
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
                    <h5 class="modal-title" id="editWarrantyModelLabel">Edit Warranty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editWarrantyModelBody">

                </div>
            </div>
        </div>
    </div>

</x-userdashboard-layout>
