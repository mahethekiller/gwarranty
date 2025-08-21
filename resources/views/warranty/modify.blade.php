<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="table-responsive">
                                    {{-- {{ dd($warranties) }} --}}

                                    <table id="warrantyTable" class="table table-bordered table-striped p-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Dealer</th>
                                                <th>Dealer State & City</th>
                                                <th>Invoice Number</th>
                                                <th>Invoice</th>
                                                {{-- <th>Remarks</th> --}}
                                                <th>Products & Remarks</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($warranties) == 0)
                                                <tr>
                                                    <td colspan="9" class="text-center">No data available</td>
                                                </tr>
                                            @else
                                                @foreach ($warranties as $index => $warranty)
                                                    <tr>
                                                        <td>{{ $warranty->created_at->format('d-M-Y') }}</td>
                                                        <td>{{ $warranty->dealer_name ?? 'N/A' }}</td>
                                                        <td>{{ $warranty->dealer_state ?? 'N/A' }}
                                                            >{{ $warranty->dealer_city ?? 'N/A' }}</td>
                                                        <td>{{ $warranty->invoice_number }}</td>
                                                        <td>
    @if ($warranty->upload_invoice)
        <a href="{{ asset('storage/invoices/' . $warranty->upload_invoice) }}"
           target="_blank"
           class="download-icon-red">
            <i class="fa fa-download"></i>&nbsp;View
        </a>
    @endif
</td>



                                                        {{-- <td>{{ $warranty->remarks }}</td> --}}
                                                        <td>
                                                            <!-- View Products Button -->
                                                            <a href="#" class="view-icon-red view-products-btn"
                                                                data-products='@json($warranty->products)'
                                                                data-title="Products for Warranty #{{ $index + 1 }}">
                                                                <i class="fa fa-eye"></i> &nbsp; View
                                                            </a>
                                                        </td>
                                                        @php
                                                            $products = $warranty->products;

                                                            if ($products->contains('branch_admin_status', 'modify')) {
                                                                $status = 'modify';
                                                            } elseif (
                                                                $products->every(function ($p) {
                                                                    return $p->branch_admin_status === 'approved' &&
                                                                        $p->country_admin_status === 'approved';
                                                                })
                                                            ) {
                                                                $status = 'approved';
                                                            } else {
                                                                $status = 'pending';
                                                            }
                                                        @endphp

                                                        <td>
                                                            @if ($status === 'pending')
                                                                <span class="badge bg-warning text-white">Pending</span>
                                                            @elseif ($status === 'approved')
                                                                <span
                                                                    class="badge bg-success text-white">Approved</span>
                                                            @elseif ($status === 'modify')
                                                                <span class="badge bg-danger text-white">Modify</span>
                                                            @endif
                                                        </td>

                                                        <td>

                                                            @if ($warranty->products->contains('branch_admin_status', 'modify'))
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#editWarrantyModel" href="#"
                                                                    data-id="{{ $warranty->id }}"
                                                                    class="edit-icon-green">
                                                                    <i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                                                                </a>
                                                            @endif

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    {{-- Pagination links --}}
                                    <div class="mt-3">
                                        {{ $warranties->links() }}
                                    </div>
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
                                                            <!-- Rows will be added dynamically -->
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

                </div>
            </div>
        </div>
    </div>


</x-userdashboard-layout>
