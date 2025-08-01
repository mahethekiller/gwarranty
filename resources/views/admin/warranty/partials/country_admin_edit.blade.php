<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="6">Product Types</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($warrantyProducts as $index => $product)
            <tr>
                <td colspan="6">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $product->product->name }}
                            {{-- Status badges --}}
                            @if (auth()->user()->hasRole('country_admin'))
                                <small class="badge rounded-pill status-badge bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'rejected' ? 'danger' : 'success') }}">
                                    Status: {{ ucfirst($product->country_admin_status) }}
                                </small>
                                <small class="badge rounded-pill bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Branch admin status: {{ ucfirst($product->branch_admin_status) }}
                                </small>
                            @endif

                            @if (auth()->user()->hasRole('branch_admin'))
                                <small class="badge rounded-pill status-badge bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Status: {{ ucfirst($product->branch_admin_status) }}
                                </small>
                                <small class="badge rounded-pill bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Country admin status: {{ ucfirst($product->country_admin_status) }}
                                </small>
                            @endif
                        </strong>

                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRow{{ $index }}" aria-expanded="false"
                            aria-controls="collapseRow{{ $index }}">
                            View Details
                        </button>
                    </div>

                    {{-- Collapsible details --}}
                    <div class="collapse mt-3" id="collapseRow{{ $index }}">
                        <div class="card card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Qty Purchased:</strong></label>
                                    <p>{{ $product->qty_purchased }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Application Type:</strong></label>
                                    <p>{{ $product->application_type ?: 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Total Quantity:</strong></label>
                                    <p>{{ $product->total_quantity }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Product Status:</strong></label>
                                    <p>{{ ucfirst($product->product_status) }}</p>
                                </div>
                            </div>

                            {{-- Product Name & Warranty --}}
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Product Name:</strong></label>
                                    <p>{{ $product->product_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Warranty:</strong></label>
                                    <p>{{ $product->warranty_years ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Additional Fields --}}
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Branch Name:</strong></label>
                                    <p>{{ $product->branch_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Invoice Date:</strong></label>
                                    <p>{{ $product->invoice_date ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Execution Agency:</strong></label>
                                    <p>{{ $product->execution_agency ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Date of Handover Certificate:</strong></label>
                                    <p>{{ $product->handover_certificate_date ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Product Code:</strong></label>
                                    <p>{{ $product->product_code ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Surface Treatment Type:</strong></label>
                                    <p>{{ $product->surface_treatment_type ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label><strong>Product Thickness:</strong></label>
                                    <p>{{ $product->product_thickness ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Project Location:</strong></label>
                                    <p>{{ $product->project_location ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Remarks --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label><strong>Remarks:</strong></label>
                                    <p>{{ $product->remarks ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
