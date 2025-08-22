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
                                <small
                                    class="badge rounded-pill status-badge bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'rejected' ? 'danger' : 'success') }}">
                                    Status: {{ ucfirst($product->country_admin_status) }}
                                </small>
                                <small
                                    class="badge rounded-pill bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Branch admin status: {{ ucfirst($product->branch_admin_status) }}
                                </small>
                            @endif

                            @if (auth()->user()->hasRole('branch_admin'))
                                <small
                                    class="badge rounded-pill status-badge bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Status: {{ ucfirst($product->branch_admin_status) }}
                                </small>
                                <small
                                    class="badge rounded-pill bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'modify' ? 'info' : 'success') }}">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label><strong>Qty Purchased:</strong></label>
                                    <p>{{ $product->qty_purchased }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Total Quantity:</strong></label>
                                    <p>{{ $product->total_quantity }}</p>
                                </div>


                                {{-- <div class="row mb-2">
                                 <div class="col-md-6">
                                    <label><strong>Application Type:</strong></label>
                                    <p>{{ $product->application_type ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Product Status:</strong></label>
                                    <p>{{ ucfirst($product->product_status) }}</p>
                                </div>
                            </div> --}}





                                {{-- Additional Fields --}}

                                <div class="col-md-6">
                                    <label><strong>Branch Name:</strong></label>
                                    <p>{{ $product->branch_name ?? 'N/A' }}</p>
                                </div>

                                @if ($product->product_type != 4)
                                    <div class="col-md-6">
                                        <label><strong>Invoice Date:</strong></label>
                                        <p>{{ $product->invoice_date ? $product->invoice_date->format('d-M-Y') : 'N/A' }}
                                        </p>
                                    </div>
                                @endif



                                @if ($product->product_type == 4 || $product->product_type == 5)
                                    <div class="col-md-6">
                                        <label><strong>Execution Agency:</strong></label>
                                        <p>{{ $product->execution_agency ?? 'N/A' }}</p>
                                    </div>
                                @endif
                                @if ($product->product_type == 5 || $product->product_type == 2 || $product->product_type == 4)
                                    <div class="col-md-6">
                                        <label><strong>Date of Handover Certificate:</strong></label>
                                        <p>{{ $product->handover_certificate_date ? $product->handover_certificate_date->format('d-M-Y') : 'N/A' }}</p>
                                    </div>
                                @endif


                                @if ($product->product_type == 1)
                                    <div class="col-md-6">
                                        <label><strong>Product Code:</strong></label>
                                        <p>{{ $product->product_code ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label><strong>Surface Treatment Type:</strong></label>
                                        <p>{{ $product->surface_treatment_type ?? 'N/A' }}</p>
                                    </div>
                                @endif

                                @if (in_array($product->product_type, [2]))
                                    @php
                                        $variants = json_decode($product->product_thickness ?? '[]', true);
                                    @endphp

                                    <div class="col-md-6">
                                        <label><strong>Product Variants:</strong></label>

                                        @if (!empty($variants))
                                            <table class="table table-bordered mt-2">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Thickness</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($variants as $index => $variant)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $variant['thickness'] ?? 'N/A' }}</td>
                                                            <td>{{ $variant['quantity'] ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label><strong>Project Location:</strong></label>
                                        <p>{{ $product->project_location ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Name & Warranty --}}
                            @if ($product->product_type == 1)
                                {{-- Floor Products --}}
                                @php
                                    $productsjsonFloor = !empty($product->products_jsonFloor)
                                        ? (is_array($product->products_jsonFloor)
                                            ? $product->products_jsonFloor
                                            : json_decode($product->products_jsonFloor, true))
                                        : [];
                                @endphp

                                @if (!empty($productsjsonFloor))
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Warranty (Years)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productsjsonFloor as $prod)
                                                <tr>
                                                    <td>{{ $prod['product_name'] ?? 'N/A' }}</td>
                                                    <td>{{ $prod['quantity'] ?? 'N/A' }}</td>
                                                    <td>{{ $prod['warranty_years'] ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No floor products found.</p>
                                @endif
                            @elseif ($product->product_type == 3)
                                {{-- Ply Products --}}
                                @php
                                    $productsjson = !empty($product->products_json)
                                        ? (is_array($product->products_json)
                                            ? $product->products_json
                                            : json_decode($product->products_json, true))
                                        : [];
                                @endphp

                                @if (!empty($productsjson))
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Warranty (Years)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productsjson as $prod)
                                                <tr>
                                                    <td>{{ $prod['product_name'] ?? 'N/A' }}</td>
                                                    <td>{{ $prod['quantity'] ?? 'N/A' }}</td>
                                                    <td>{{ $prod['warranty_years'] ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No ply products found.</p>
                                @endif
                            @else
                                {{-- Single Product --}}
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Warranty (Years)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $product->product_name ?? 'N/A' }}</td>
                                            <td>{{ $product->warranty_years ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

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
