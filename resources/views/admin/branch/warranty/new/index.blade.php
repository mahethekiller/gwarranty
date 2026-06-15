<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="''">
    @push('styles')
    <style>
        .grouped-row {
            background-color: rgba(0, 123, 255, 0.02) !important;
        }
        .group-indicator {
            border-left: 4px solid #007bff !important;
        }
        .group-indicator-sub {
            border-left: 4px solid #dee2e6 !important;
        }
    </style>
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Branch Warranty Management</h4>
                <a href="{{ route('branch.warranties.new.export') }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Export CSV</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="warrantyTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dealer</th>
                                <th>Invoice Details</th>
                                <th>Location</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Date</th>
                                @if(!auth()->user()->hasRole('admin'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $prevInvoice = null; @endphp
                            @forelse($warranties as $warranty)
                                @php
                                    $isGrouped = $prevInvoice === $warranty->invoice_number;
                                    $prevInvoice = $warranty->invoice_number;
                                @endphp
                                <tr class="{{ $isGrouped ? 'grouped-row' : '' }}">
                                    <td class="{{ $warranty->invoice_group_count > 1 ? ($isGrouped ? 'group-indicator-sub' : 'group-indicator') : '' }}">
                                        {{ $warranty->id }}
                                    </td>
                                <td>
                                    {{ $warranty->dealer_name }}<br>
                                    <small>{{ $warranty->user->name ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $warranty->invoice_number }}
                                    @if($warranty->invoice_group_count > 1)
                                        <span class="badge bg-warning text-dark border ms-1" title="Multiple registrations for this invoice">
                                            <i class="fa fa-copy"></i> Existing Invoice
                                        </span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $warranty->invoice_date ? $warranty->invoice_date->format('d M Y') : 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $warranty->dealer_city }}, {{ $warranty->dealer_state }}
                                </td>
                                <td>
                                    @foreach($warranty->productDetails as $p)
                                        <div class="mb-2 pb-1 {{ !$loop->last ? 'border-bottom' : '' }}" style="font-size: 0.85rem; min-width: 250px;">
                                            <div class="d-flex justify-content-between">
                                                <span><strong>S/No:</strong> <code class="text-dark">{{ $p->serial_number ?? 'N/A' }}</code></span>
                                                @php
                                                    $pBadge = match($p->status) {
                                                        'approved' => 'bg-success',
                                                        'rejected' => 'bg-danger',
                                                        'modify' => 'bg-warning text-dark',
                                                        default => 'bg-primary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $pBadge }}" style="font-size: 0.7rem;">{{ ucfirst($p->status) }}</span>
                                            </div>
                                            <div><strong>Type:</strong> {{ $p->productType->name ?? 'N/A' }}</div>
                                            <div><strong>Variant:</strong> {{ $p->variant ?? ($p->productTypeVariant->name ?? 'N/A') }}</div>
                                            <div>
                                                <strong>Qty:</strong> {{ $p->quantity ?? ($p->total_quantity ?? 0) }} {{ $p->uom ?? '' }}
                                                @if($p->no_of_boxes) <span class="text-muted">({{ $p->no_of_boxes }} boxes)</span> @endif
                                                @if($p->area_sqft) <span class="text-muted">({{ $p->area_sqft }} sqft)</span> @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($warranty->overall_status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'modify' => 'bg-warning',
                                            default => 'bg-primary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($warranty->overall_status) }}
                                    </span>
                                </td>
                                <td>{{ $warranty->created_at->format('d M Y') }}</td>
                                @if(!auth()->user()->hasRole('admin'))
                                <td>
                                    <a href="{{ route('branch.warranties.new.edit', $warranty->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i> Process
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No warranties found for your branch.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $warranties->links() }}
                </div>
            </div>
        </div>
    </div>
</x-userdashboard-layout>
