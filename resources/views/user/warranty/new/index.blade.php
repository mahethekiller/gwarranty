<x-userdashboard-layout :pageTitle="'My Warranties'" :pageDescription="'View and manage your warranty registrations'">
    @push('styles')
    <style>
        /* ── Palette ──────────────────────────────────────────── */
        :root {
            --clr-modify:  #f59e0b;
            --clr-pending: #3b82f6;
            --clr-approved:#10b981;
            --clr-rejected:#ef4444;
        }

        /* ── Action-required alert banner ────────────────────── */
        .action-required-banner {
            border-left: 5px solid var(--clr-modify);
            background: linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%);
            border-radius: 10px;
            animation: pulse-border 2s infinite;
        }
        @keyframes pulse-border {
            0%,100% { border-left-color: var(--clr-modify); }
            50%      { border-left-color: #d97706; }
        }

        /* ── Status row highlight ────────────────────────────── */
        .row-modify   { background: rgba(245,158,11,.06) !important; }
        .row-pending  { background: rgba(59,130,246,.04) !important; }
        .row-rejected { background: rgba(239,68,68,.05) !important; }
        .row-approved { background: rgba(16,185,129,.04) !important; }

        .group-indicator     { border-left: 4px solid var(--clr-pending) !important; }
        .group-indicator-sub { border-left: 4px solid #dee2e6 !important; }

        /* ── Status badges ───────────────────────────────────── */
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: .75rem; font-weight: 600; letter-spacing: .3px;
        }
        .status-pill.modify   { background:#fef3c7; color:#92400e; border:1px solid #fcd34d; }
        .status-pill.pending  { background:#dbeafe; color:#1e40af; border:1px solid #93c5fd; }
        .status-pill.approved { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
        .status-pill.rejected { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

        /* ── Product chips ───────────────────────────────────── */
        .product-chip {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 8px; border-radius: 6px; font-size: .72rem;
            font-weight: 500; margin: 2px 2px 2px 0;
        }
        .chip-modify   { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
        .chip-pending  { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
        .chip-approved { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
        .chip-rejected { background:#fff1f2; color:#be123c; border:1px solid #fecdd3; }

        /* ── Remarks cell ────────────────────────────────────── */
        .remark-block {
            background: #fff8ec; border-left: 3px solid #fbbf24;
            border-radius: 5px; padding: 5px 8px;
            font-size: .78rem; color: #78350f; max-width: 200px;
        }

        /* ── Action buttons ──────────────────────────────────── */
        .btn-action-edit {
            background: linear-gradient(135deg,#f59e0b,#d97706);
            color:#fff; border:none; border-radius:8px;
            padding: 6px 14px; font-size:.8rem; font-weight:600;
            box-shadow: 0 2px 8px rgba(245,158,11,.4);
            transition: transform .15s, box-shadow .15s;
        }
        .btn-action-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(245,158,11,.5);
            color:#fff;
        }
        .btn-action-view {
            background: linear-gradient(135deg,#3b82f6,#2563eb);
            color:#fff; border:none; border-radius:8px;
            padding: 6px 14px; font-size:.8rem; font-weight:600;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-action-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(59,130,246,.4);
            color:#fff;
        }

        /* ── Stats bar ───────────────────────────────────────── */
        .stat-card {
            border-radius: 10px; padding: 14px 18px;
            display: flex; align-items: center; gap: 12px;
            transition: transform .15s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-icon { width:40px; height:40px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.1rem; }
        .stat-num  { font-size:1.4rem; font-weight:700; line-height:1; }
        .stat-lbl  { font-size:.72rem; color:#6b7280; font-weight:500; }

        .stat-modify   { background:#fff7ed; }
        .stat-pending  { background:#eff6ff; }
        .stat-approved { background:#f0fdf4; }
        .stat-rejected { background:#fff1f2; }
        .stat-icon.modify   { background:#fed7aa; color:#c2410c; }
        .stat-icon.pending  { background:#bfdbfe; color:#1d4ed8; }
        .stat-icon.approved { background:#bbf7d0; color:#15803d; }
        .stat-icon.rejected { background:#fecdd3; color:#be123c; }

        /* ── Table ───────────────────────────────────────────── */
        .warranty-table th {
            font-size: .78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .5px;
            color: #4b5563; background: #f9fafb;
            border-bottom: 2px solid #e5e7eb; white-space: nowrap;
        }
        .warranty-table td { vertical-align: middle; }
        .warranty-table tr { transition: background .15s; }
    </style>
    @endpush

    @php
        /* ── Pre-compute summary counts ──────────────────────── */
        $modifyCount   = $warranties->filter(fn($w) => $w->overall_status === 'modify')->count();
        $pendingCount  = $warranties->filter(fn($w) => $w->overall_status === 'pending')->count();
        $approvedCount = $warranties->filter(fn($w) => $w->overall_status === 'approved')->count();
        $rejectedCount = $warranties->filter(fn($w) => $w->overall_status === 'rejected')->count();
    @endphp

    {{-- ── Action-Required Banner ─────────────────────────────── --}}
    @if($modifyCount > 0)
    <div class="action-required-banner p-4 mb-4 d-flex align-items-center gap-3">
        <div style="font-size:2rem;">⚠️</div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold text-warning-emphasis">Action Required</h6>
            <p class="mb-0 text-dark" style="font-size:.88rem;">
                You have <strong>{{ $modifyCount }} {{ Str::plural('warranty', $modifyCount) }}</strong>
                that require your attention. Please review the admin remarks and make the necessary corrections.
            </p>
        </div>
        <a href="#modify-section" class="btn btn-warning btn-sm fw-semibold px-3">
            <i class="fa fa-arrow-down me-1"></i> View Now
        </a>
    </div>
    @endif

    {{-- ── Stats Bar ────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card stat-modify">
                <div class="stat-icon modify"><i class="fa fa-edit"></i></div>
                <div>
                    <div class="stat-num text-warning">{{ $modifyCount }}</div>
                    <div class="stat-lbl">Needs Modification</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card stat-pending">
                <div class="stat-icon pending"><i class="fa fa-clock"></i></div>
                <div>
                    <div class="stat-num text-primary">{{ $pendingCount }}</div>
                    <div class="stat-lbl">Under Review</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card stat-approved">
                <div class="stat-icon approved"><i class="fa fa-check-circle"></i></div>
                <div>
                    <div class="stat-num text-success">{{ $approvedCount }}</div>
                    <div class="stat-lbl">Approved</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card stat-rejected">
                <div class="stat-icon rejected"><i class="fa fa-times-circle"></i></div>
                <div>
                    <div class="stat-num text-danger">{{ $rejectedCount }}</div>
                    <div class="stat-lbl">Rejected</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Session Flash Messages ───────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Main Table Card ──────────────────────────────────────── --}}
    <div class="card shadow-sm" id="modify-section">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title mb-0 fw-semibold">
                <i class="fa fa-shield-alt me-2 text-primary"></i>My Warranty Registrations
            </h5>
            <a href="{{ route('user.warranty.new.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="fa fa-plus me-1"></i> New Registration
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover warranty-table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Invoice</th>
                            <th>Submitted</th>
                            <th>Dealer</th>
                            <th>Products &amp; Status</th>
                            <th>Overall Status</th>
                            <th>Admin Remarks</th>
                            <th class="pe-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $prevInvoice = null; @endphp
                        @forelse($warranties as $warranty)
                            @php
                                $ovStatus  = $warranty->overall_status;
                                $isGrouped = $prevInvoice === $warranty->invoice_number;
                                $prevInvoice = $warranty->invoice_number;
                                $rowClass  = match($ovStatus) {
                                    'modify'   => 'row-modify',
                                    'rejected' => 'row-rejected',
                                    'approved' => 'row-approved',
                                    default    => 'row-pending',
                                };
                                $modifyProducts = $warranty->productDetails->where('status','modify');
                                $productRemarks = $warranty->productDetails->filter(fn($p) => !empty($p->admin_remarks));
                            @endphp
                            <tr class="{{ $rowClass }}">

                                {{-- # --}}
                                <td class="ps-3 {{ $warranty->invoice_group_count > 1 ? ($isGrouped ? 'group-indicator-sub' : 'group-indicator') : '' }}">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Invoice --}}
                                <td>
                                    <strong class="d-block">{{ $warranty->invoice_number }}</strong>
                                    <small class="text-muted">{{ $warranty->invoice_date?->format('d M Y') ?? '—' }}</small>
                                    @if($warranty->invoice_group_count > 1)
                                        <span class="badge bg-warning text-dark border ms-1 d-block mt-1" style="font-size:.65rem;">
                                            <i class="fa fa-copy"></i> Existing Invoice
                                        </span>
                                    @endif
                                </td>

                                {{-- Submitted --}}
                                <td>
                                    <span class="d-block">{{ $warranty->created_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $warranty->created_at->format('h:i A') }}</small>
                                </td>

                                {{-- Dealer --}}
                                <td>
                                    <span class="d-block">{{ $warranty->dealer_name }}</span>
                                    <small class="text-muted">{{ $warranty->dealer_city }}, {{ $warranty->dealer_state }}</small>
                                </td>

                                {{-- Products & per-product status --}}
                                <td>
                                    @foreach($warranty->productDetails as $product)
                                        @php
                                            $chipClass = match($product->status) {
                                                'modify'   => 'chip-modify',
                                                'approved' => 'chip-approved',
                                                'rejected' => 'chip-rejected',
                                                default    => 'chip-pending',
                                            };
                                            $chipIcon = match($product->status) {
                                                'modify'   => '✏️',
                                                'approved' => '✅',
                                                'rejected' => '❌',
                                                default    => '🕐',
                                            };
                                        @endphp
                                        <span class="product-chip {{ $chipClass }}" title="{{ $product->admin_remarks ?? '' }}">
                                            {{ $chipIcon }}
                                            {{ $product->productType->name }}
                                            @if($product->quantity)
                                                <span class="opacity-75">({{ $product->quantity }})</span>
                                            @endif
                                        </span>
                                    @endforeach

                                    @if($modifyProducts->count() > 0)
                                        <div class="mt-1">
                                            <small class="text-warning fw-semibold">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                {{ $modifyProducts->count() }} {{ Str::plural('product', $modifyProducts->count()) }} need correction
                                            </small>
                                        </div>
                                    @endif
                                </td>

                                {{-- Overall Status --}}
                                <td>
                                    @php
                                        $pillIcon = match($ovStatus) {
                                            'modify'   => '<i class="fa fa-edit"></i>',
                                            'approved' => '<i class="fa fa-check-circle"></i>',
                                            'rejected' => '<i class="fa fa-times-circle"></i>',
                                            default    => '<i class="fa fa-hourglass-half"></i>',
                                        };
                                        $pillLabel = match($ovStatus) {
                                            'modify'   => 'Modify Required',
                                            'approved' => 'Approved',
                                            'rejected' => 'Rejected',
                                            default    => 'Under Review',
                                        };
                                    @endphp
                                    <span class="status-pill {{ $ovStatus }}">
                                        {!! $pillIcon !!} {{ $pillLabel }}
                                    </span>
                                </td>

                                {{-- Admin Remarks --}}
                                <td>
                                    @if($productRemarks->isNotEmpty())
                                        @foreach($productRemarks as $remarkedProduct)
                                            <div class="remark-block mb-1">
                                                <strong style="font-size:.7rem;">{{ $remarkedProduct->productType->name }}:</strong><br>
                                                {{ Str::limit($remarkedProduct->admin_remarks, 60) }}
                                            </div>
                                        @endforeach
                                    @elseif($warranty->admin_remarks)
                                        <div class="remark-block">
                                            {{ Str::limit($warranty->admin_remarks, 80) }}
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size:.8rem;">—</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="pe-3 text-center">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <a href="{{ route('user.warranty.show', $warranty->id) }}"
                                           class="btn-action-view text-decoration-none d-inline-flex align-items-center gap-1">
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        @if($warranty->can_be_edited)
                                            <a href="{{ route('user.warranty.new.edit', $warranty->id) }}"
                                               class="btn-action-edit text-decoration-none d-inline-flex align-items-center gap-1">
                                                <i class="fa fa-edit"></i> Fix Now
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa fa-inbox fa-3x mb-3 d-block opacity-30"></i>
                                    No warranty registrations found.<br>
                                    <a href="{{ route('user.warranty.new.create') }}" class="btn btn-primary btn-sm mt-3">
                                        <i class="fa fa-plus me-1"></i> Register Your First Warranty
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($warranties->hasPages())
                <div class="d-flex justify-content-center py-3 border-top">
                    {{ $warranties->links() }}
                </div>
            @endif
        </div>
    </div>
</x-userdashboard-layout>
