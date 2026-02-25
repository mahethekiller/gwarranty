<x-userdashboard-layout :pageTitle="'Warranty Details'" :pageDescription="'View warranty registration details'">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Warranty Details</h5>
                        <div>
                            @if($warranty->status === 'modify')
                                <a href="{{ route('user.warranty.edit', $warranty->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit me-1"></i> Edit Warranty
                                </a>
                            @endif
                            <a href="{{ route('user.warranties.index') }}" class="btn btn-secondary btn-sm ms-1">
                                <i class="fa fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Status Alert -->
                    @if($warranty->status === 'modify')
                        <div class="alert alert-warning">
                            <h6><i class="fa fa-exclamation-triangle me-2"></i> Modification Required</h6>
                            <p class="mb-0">{{ $warranty->admin_remarks ?? 'Please update your warranty information as requested by the administrator.' }}</p>
                            <a href="{{ route('user.warranty.edit', $warranty->id) }}" class="btn btn-warning btn-sm mt-2">
                                <i class="fa fa-edit me-1"></i> Edit Now
                            </a>
                        </div>
                    @elseif($warranty->status === 'approved')
                        <div class="alert alert-success">
                            <h6><i class="fa fa-check-circle me-2"></i> Warranty Approved</h6>
                            <p class="mb-0">Your warranty has been approved. You can download the certificate.</p>
                            <a href="{{ route('user.warranty.certificate.download', $warranty->id) }}" class="btn btn-success btn-sm mt-2">
                                <i class="fa fa-download me-1"></i> Download Certificate
                            </a>
                        </div>
                    @elseif($warranty->status === 'rejected')
                        <div class="alert alert-danger">
                            <h6><i class="fa fa-times-circle me-2"></i> Warranty Rejected</h6>
                            <p class="mb-0">{{ $warranty->admin_remarks ?? 'Your warranty registration has been rejected.' }}</p>
                        </div>
                    @endif

                    <!-- Dealer Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Dealer Information</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dealer Name</label>
                            <p class="form-control-plaintext">{{ $warranty->dealer_name }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dealer State</label>
                            <p class="form-control-plaintext">{{ $warranty->dealer_state }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dealer City</label>
                            <p class="form-control-plaintext">{{ $warranty->dealer_city }}</p>
                        </div>
                    </div>

                    <!-- Invoice Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Invoice Information</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Invoice Number</label>
                            <p class="form-control-plaintext">{{ $warranty->invoice_number }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Invoice Date</label>
                            <p class="form-control-plaintext">{{ $warranty->invoice_date ? $warranty->invoice_date->format('d M, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Invoice File</label>
                            <br>
                            <a href="{{ Storage::url($warranty->invoice_file_path) }}"
                               target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-download me-1"></i> View Invoice
                            </a>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Product Details</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Type</th>
                                            <th>Variant</th>
                                            <th>Product Name/Design</th>
                                            <th>Category</th>
                                            <th>No. of Boxes</th>
                                            <th>Quantity</th>
                                            <th>Area (Sq. Ft.)</th>
                                            <th>UoM</th>
                                            <th>Site Address</th>
                                            <th>Thickness</th>
                                            <th>Handover Certificate</th>
                                            <th>Status</th>
                                            <th>Admin Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($warranty->productDetails as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->productType->name }}</td>
                                                <td>
                                                    @if($product->variant)
                                                        {{ $product->variant }}
                                                    @elseif($product->variant_id && $product->variant)
                                                        {{ $product->variant->variant_name }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $product->product_name_design ?? 'N/A' }}</td>
                                                <td>{{ $product->product_category ?? 'N/A' }}</td>
                                                <td>{{ $product->no_of_boxes ?? 'N/A' }}</td>
                                                <td>{{ $product->quantity ?? 'N/A' }}</td>
                                                <td>{{ $product->area_sqft ?? 'N/A' }}</td>
                                                <td>{{ $product->uom ?? 'N/A' }}</td>
                                                <td>
                                                    @if($product->site_address)
                                                        <small>{{ Str::limit($product->site_address, 30) }}</small>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $product->product_thickness ?? 'N/A' }}</td>
                                                <td>
                                                    @if($product->handover_certificate)
                                                        <a href="{{ Storage::url($product->handover_certificate) }}"
                                                           target="_blank" class="btn btn-sm btn-outline-info">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->status === 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($product->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($product->status === 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif($product->status === 'modify')
                                                        <span class="badge bg-primary">Modify Required</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->admin_remarks)
                                                        <small class="text-danger">{{ $product->admin_remarks }}</small>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Timeline</h6>
                            <ul class="timeline">
                                <li class="timeline-item">
                                    <span class="timeline-date">{{ $warranty->created_at->format('d M Y, h:i A') }}</span>
                                    <span class="timeline-event">Warranty Registered</span>
                                </li>
                                @if($warranty->status === 'approved')
                                    <li class="timeline-item">
                                        <span class="timeline-date">{{ $warranty->updated_at->format('d M Y, h:i A') }}</span>
                                        <span class="timeline-event">Warranty Approved</span>
                                    </li>
                                @elseif($warranty->status === 'rejected')
                                    <li class="timeline-item">
                                        <span class="timeline-date">{{ $warranty->updated_at->format('d M Y, h:i A') }}</span>
                                        <span class="timeline-event">Warranty Rejected</span>
                                    </li>
                                @elseif($warranty->status === 'modify')
                                    <li class="timeline-item">
                                        <span class="timeline-date">{{ $warranty->updated_at->format('d M Y, h:i A') }}</span>
                                        <span class="timeline-event">Modification Requested</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            list-style: none;
            padding-left: 0;
        }
        .timeline-item {
            padding: 10px 0;
            border-left: 3px solid #007bff;
            padding-left: 20px;
            position: relative;
            margin-left: 10px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -8px;
            top: 15px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #007bff;
        }
        .timeline-date {
            font-weight: bold;
            color: #6c757d;
            display: block;
            font-size: 0.9rem;
        }
        .timeline-event {
            font-weight: 500;
            color: #495057;
        }
        .form-control-plaintext {
            min-height: 38px;
            padding: 6px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>
</x-userdashboard-layout>
