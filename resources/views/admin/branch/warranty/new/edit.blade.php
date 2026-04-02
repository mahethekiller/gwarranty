<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="''">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Process Warranty #{{ $warranty->id }}</h4>
                <a href="{{ route('branch.warranties.new.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                @if($relatedWarranties->isNotEmpty())
                    <div class="alert alert-info border-primary mb-4">
                        <h6 class="alert-heading text-primary"><i class="fa fa-info-circle me-1"></i> Shared Invoice Detected</h6>
                        <p class="mb-0">There are <strong>{{ $relatedWarranties->count() }}</strong> other registrations for this invoice ({{ $warranty->invoice_number }}).</p>
                        <hr class="my-2">
                        <ul class="mb-0 small">
                            @foreach($relatedWarranties as $related)
                                <li>
                                    <a href="{{ route('branch.warranties.new.edit', $related->id) }}" class="text-primary text-decoration-none">
                                        Registration #{{ $related->id }} ({{ $related->created_at->format('d M Y') }}) - Status: {{ ucfirst($related->overall_status) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Warranty Details --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Dealer:</strong> {{ $warranty->dealer_name }}<br>
                        <strong>Location:</strong> {{ $warranty->dealer_city }}, {{ $warranty->dealer_state }}
                    </div>
                    <div class="col-md-4">
                        <strong>Customer:</strong> {{ $warranty->user->name ?? 'N/A' }}<br>
                        <strong>Email:</strong> {{ $warranty->user->email ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Invoice No:</strong> {{ $warranty->invoice_number }}<br>
                        <strong>Invoice Date:</strong>
                        {{ $warranty->invoice_date ? $warranty->invoice_date->format('d M, Y') : 'N/A' }}<br>
                        @if ($warranty->invoice_file_path)
                            <a href="{{ Storage::url($warranty->invoice_file_path) }}" target="_blank"
                                class="btn btn-xs btn-info mt-1">View Invoice</a>
                        @endif
                    </div>
                </div>

                <form action="{{ route('branch.warranties.new.update', $warranty->id) }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Product Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20%">Product Info</th>
                                    <th width="12%">Details</th>
                                    <th width="18%">Site Address</th>
                                    {{-- <th width="15%">Docs</th> --}}
                                    <th width="15%">Status</th>
                                    <th width="10%">Total Qty <span class="text-danger">*</span></th>
                                    <th width="20%">Admin Remarks <small class="text-danger">(Required for Rejected/Modify)</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warranty->productDetails as $index => $product)
                                    <tr>
                                        <td>
                                            <strong>{{ $product->productType->name }}</strong>
                                            @if ($product->serial_number)
                                                <br><span class="text-secondary"><strong>S/N:</strong> {{ $product->serial_number }}</span>
                                            @endif
                                            @php
                                                $variantDisp = $product->variant ?: ($product->productTypeVariant->variant_name ?? null);
                                                $usageType = $product->productTypeVariant->usage_type ?? null;
                                            @endphp
                                            @if ($variantDisp)
                                                <br>Variant: {{ $variantDisp }}
                                                @if($usageType)
                                                    <span class="text-muted">({{ $usageType }})</span>
                                                @endif
                                            @endif
                                            @if ($product->product_name_design)
                                                <br><span class="text-info">Design:
                                                    {{ $product->product_name_design }}</span>
                                            @endif
                                            @if ($product->product_category)
                                                <br>Cat: {{ $product->product_category }}
                                            @endif
                                            @if ($product->handover_certificate)
                                                <br><a href="{{ Storage::url($product->handover_certificate) }}"
                                                    target="_blank" class="btn btn-info mb-1"
                                                    style="font-size: 13px; padding: 2px 4px; line-height: 1.5;"><i
                                                        class="fa fa-file-pdf-o"></i> Handover Certificate.</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->quantity)
                                                <span class="text-primary">Quantity: {{ $product->quantity }}
                                                    {{ $product->uom }}</span><br>
                                            @endif
                                            @if ($product->area_sqft)
                                                <span class="text-primary">Area: {{ $product->area_sqft }}
                                                    Sq.Ft.</span><br>
                                            @endif
                                            @if ($product->no_of_boxes)
                                                <span class="text-primary">Boxes:
                                                    {{ $product->no_of_boxes }}</span><br>
                                            @endif
                                            @if ($product->product_thickness)
                                                <span class="text-danger">Thickness:
                                                    {{ $product->product_thickness }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $product->site_address ?? '-' }}
                                        </td>

                                         <td>
                                             @php
                                                 $isLocked = in_array($product->status, ['approved', 'rejected']);
                                             @endphp
                                             <input type="hidden" name="products[{{ $index }}][id]"
                                                 value="{{ $product->id }}">
                                             <select class="form-select form-select-sm status-select" data-index="{{ $index }}"
                                                 name="products[{{ $index }}][status]" {{ $isLocked ? 'disabled' : '' }}>
                                                 <option value="pending"
                                                     {{ $product->status === 'pending' ? 'selected' : '' }}>Pending
                                                 </option>
                                                 <option value="approved"
                                                     {{ $product->status === 'approved' ? 'selected' : '' }}>Approved
                                                 </option>
                                                 <option value="modify"
                                                     {{ $product->status === 'modify' ? 'selected' : '' }}>Modify
                                                     Required</option>
                                                 <option value="rejected"
                                                     {{ $product->status === 'rejected' ? 'selected' : '' }}>Rejected
                                                 </option>
                                             </select>
                                             @if($isLocked)
                                                 <input type="hidden" name="products[{{ $index }}][status]" value="{{ $product->status }}">
                                                 <div class="mt-1 small text-muted"><i class="fa fa-lock"></i> Locked</div>
                                             @endif
                                         </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                name="products[{{ $index }}][total_quantity]"
                                                value="{{ $product->total_quantity ?? ($product->quantity ?? $product->no_of_boxes)  }}" min="1"
                                                max="{{ $product->quantity ?? $product->no_of_boxes }}"
                                                placeholder="Total Qty" required {{ $isLocked ? 'readonly' : '' }}>
                                            <small class="text-muted">Max: {{ $product->quantity ?? $product->no_of_boxes }}</small>
                                            @if($isLocked)
                                                <input type="hidden" name="products[{{ $index }}][total_quantity]" value="{{ $product->total_quantity }}">
                                            @endif
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm remarks-textarea" name="products[{{ $index }}][admin_remarks]" rows="2"
                                                placeholder="Remarks for customer..." {{ $isLocked ? 'readonly' : '' }}>{{ $product->admin_remarks }}</textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-userdashboard-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');

        statusSelects.forEach(select => {
            const index = select.getAttribute('data-index');
            const textarea = document.querySelector(`.remarks-textarea[name="products[${index}][admin_remarks]"]`);

            function updateRequired() {
                if (select.value === 'rejected' || select.value === 'modify') {
                    textarea.setAttribute('required', 'required');
                    textarea.setAttribute('placeholder', 'Remarks are mandatory for ' + select.value + ' status...');
                } else {
                    textarea.removeAttribute('required');
                    textarea.setAttribute('placeholder', 'Remarks for customer...');
                }
            }

            select.addEventListener('change', updateRequired);
            updateRequired(); // Initial check
        });
    });
</script>
