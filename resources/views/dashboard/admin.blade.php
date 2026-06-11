<x-userdashboard-layout :pageTitle="'Admin Dashboard'" :pageDescription="'System Admin Warranty Overview'">
    @push('styles')
    <style>
        /* ── Tokens ───────────────────────────────────────────── */
        :root {
            --c-modify:  #f59e0b;
            --c-pending: #3b82f6;
            --c-approved:#10b981;
            --c-rejected:#ef4444;
            --c-total:   #8b5cf6;
            --c-admin:   #b91c1c;
        }

        /* ── Hero card ────────────────────────────────────────── */
        .hero-card {
            background: linear-gradient(135deg,#7f1d1d 0%,#b91c1c 100%);
            border-radius: 16px; color:#fff; padding: 28px 32px;
            position: relative; overflow: hidden;
        }
        .hero-card::before {
            content:''; position:absolute; right:-50px; top:-50px;
            width:240px; height:240px; border-radius:50%;
            background: rgba(255,255,255,.06);
        }
        .hero-card::after {
            content:''; position:absolute; right:60px; bottom:-70px;
            width:170px; height:170px; border-radius:50%;
            background: rgba(255,255,255,.04);
        }
        .hero-greeting  { font-size:1.5rem; font-weight:700; }
        .hero-sub       { font-size:.88rem; opacity:.8; margin-top:4px; }
        .hero-meta {
            display:flex; gap:18px; margin-top:14px; flex-wrap:wrap;
        }
        .hero-meta-item {
            background:rgba(255,255,255,.13); border-radius:10px;
            padding:6px 14px; font-size:.78rem;
            display:flex; align-items:center; gap:6px;
        }

        /* ── Stats row ────────────────────────────────────────── */
        .stat-card {
            border-radius:14px; padding:20px;
            display:flex; align-items:center; gap:16px;
            border:1px solid transparent;
            transition:transform .18s, box-shadow .18s;
            text-decoration:none; color:inherit;
        }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.1); color:inherit; }
        .stat-icon {
            width:52px; height:52px; border-radius:13px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.3rem; flex-shrink:0;
        }
        .stat-num   { font-size:2rem; font-weight:800; line-height:1; }
        .stat-label { font-size:.75rem; color:#6b7280; font-weight:500; margin-top:3px; }

        .card-total    { background:#faf5ff; border-color:#e9d5ff; }
        .card-pending  { background:#eff6ff; border-color:#bfdbfe; }
        .card-modify   { background:#fffbeb; border-color:#fde68a; }
        .card-approved { background:#f0fdf4; border-color:#bbf7d0; }
        .card-rejected { background:#fff1f2; border-color:#fecdd3; }

        .icon-total    { background:#ede9fe; color:#7c3aed; }
        .icon-pending  { background:#dbeafe; color:#1d4ed8; }
        .icon-modify   { background:#fef3c7; color:#b45309; }
        .icon-approved { background:#d1fae5; color:#065f46; }
        .icon-rejected { background:#fee2e2; color:#991b1b; }

        /* ── Pending alert banner ─────────────────────────────── */
        .action-banner {
            border-left:5px solid var(--c-pending);
            background:linear-gradient(135deg,#eff6ff,#dbeafe);
            border-radius:12px; padding:16px 20px;
            display:flex; align-items:center; gap:14px;
        }

        /* ── Quick action tiles ───────────────────────────────── */
        .quick-tile {
            border-radius:14px; padding:20px 18px;
            display:flex; flex-direction:column; gap:8px;
            text-decoration:none; color:inherit;
            border:1px solid #e5e7eb;
            transition:transform .18s, box-shadow .18s, border-color .18s;
        }
        .quick-tile:hover {
            transform:translateY(-4px);
            box-shadow:0 10px 28px rgba(0,0,0,.1);
            border-color:#d1d5db; color:inherit; text-decoration:none;
        }
        .tile-icon {
            width:44px; height:44px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.2rem;
        }
        .tile-title { font-weight:600; font-size:.9rem; }
        .tile-desc  { font-size:.75rem; color:#9ca3af; }

        /* ── Table ────────────────────────────────────────────── */
        .admin-table th {
            font-size:.73rem; text-transform:uppercase;
            letter-spacing:.5px; color:#6b7280; font-weight:600;
            background:#f9fafb; border-bottom:2px solid #e5e7eb;
            white-space:nowrap;
        }
        .admin-table td { vertical-align:middle; }

        /* ── Status pills ─────────────────────────────────────── */
        .s-pill {
            display:inline-flex; align-items:center; gap:4px;
            padding:3px 10px; border-radius:20px;
            font-size:.72rem; font-weight:600;
        }
        .s-pill.pending  { background:#dbeafe; color:#1e40af; }
        .s-pill.approved { background:#d1fae5; color:#065f46; }
        .s-pill.rejected { background:#fee2e2; color:#991b1b; }
        .s-pill.modify   { background:#fef3c7; color:#92400e; }

        /* ── Product chips ────────────────────────────────────── */
        .p-chip {
            display:inline-block; padding:2px 8px;
            border-radius:6px; font-size:.7rem; font-weight:500;
            background:#f3f4f6; color:#374151;
            border:1px solid #e5e7eb; margin:1px;
        }
        .p-chip.modify   { background:#fff7ed; color:#c2410c; border-color:#fed7aa; }
        .p-chip.approved { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
        .p-chip.rejected { background:#fff1f2; color:#be123c; border-color:#fecdd3; }

        /* ── Row tints ────────────────────────────────────────── */
        .row-pending  { background:rgba(59,130,246,.04) !important; }
        .row-modify   { background:rgba(245,158,11,.06) !important; }
        .row-approved { background:rgba(16,185,129,.04) !important; }
        .row-rejected { background:rgba(239,68,68,.05) !important; }
    </style>
    @endpush

    @php $user = Auth::user(); @endphp

    {{-- ── Hero Card ─────────────────────────────────────────── --}}
    <div class="hero-card mb-4">
        <div class="hero-greeting">🛡️ System Administration</div>
        <div class="hero-sub">Welcome back, <strong>{{ $user->name }}</strong> — Global System Overview</div>
        <div class="hero-meta">
            <div class="hero-meta-item">
                <i class="fa fa-globe"></i>
                All Branches & Regions
            </div>
            <div class="hero-meta-item">
                <i class="fa fa-users"></i>
                Admin Access Level
            </div>
        </div>
    </div>

    {{-- ── Pending Alert ─────────────────────────────────────── --}}
    @if($pending > 0)
    <div class="action-banner mb-4">
        <div style="font-size:2rem; flex-shrink:0">📋</div>
        <div class="flex-grow-1">
            <div class="fw-bold" style="color:#1e40af; margin-bottom:3px;">System-wide Warranties Awaiting Review</div>
            <div style="font-size:.85rem; color:#1e3a8a;">
                <strong>{{ $pending }} {{ Str::plural('warranty', $pending) }}</strong> across all branches are pending review.
            </div>
        </div>
        <a href="{{ route('branch.warranties.new.index') }}" class="btn btn-primary btn-sm fw-semibold px-3 flex-shrink-0">
            <i class="fa fa-eye me-1"></i> View All
        </a>
    </div>
    @endif

    {{-- ── Stats Row ────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <a href="{{ route('branch.warranties.new.index') }}" class="stat-card card-total d-flex">
                <div class="stat-icon icon-total"><i class="fa fa-th-large"></i></div>
                <div>
                    <div class="stat-num" style="color:#7c3aed;">{{ $total }}</div>
                    <div class="stat-label">Total Registrations</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg">
            <a href="{{ route('branch.warranties.new.index') }}" class="stat-card card-pending d-flex"
               style="{{ $pending > 0 ? 'border-color:#93c5fd; box-shadow:0 0 0 3px rgba(59,130,246,.12);' : '' }}">
                <div class="stat-icon icon-pending"><i class="fa fa-hourglass-half"></i></div>
                <div>
                    <div class="stat-num" style="color:#1d4ed8;">{{ $pending }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card card-modify">
                <div class="stat-icon icon-modify"><i class="fa fa-edit"></i></div>
                <div>
                    <div class="stat-num" style="color:#b45309;">{{ $modify }}</div>
                    <div class="stat-label">Modify Sent</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card card-approved">
                <div class="stat-icon icon-approved"><i class="fa fa-check-circle"></i></div>
                <div>
                    <div class="stat-num" style="color:#065f46;">{{ $approved }}</div>
                    <div class="stat-label">Approved</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card card-rejected">
                <div class="stat-icon icon-rejected"><i class="fa fa-times-circle"></i></div>
                <div>
                    <div class="stat-num" style="color:#991b1b;">{{ $rejected }}</div>
                    <div class="stat-label">Rejected</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Quick Actions ─────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <h6 class="fw-semibold text-muted mb-2" style="font-size:.78rem; text-transform:uppercase; letter-spacing:.6px;">
                Administrative Actions
            </h6>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#dbeafe; color:#1d4ed8;"><i class="fa fa-users"></i></div>
                <div class="tile-title">User Management</div>
                <div class="tile-desc">Manage system users &amp; roles</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.product-types.index') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#d1fae5; color:#065f46;"><i class="fa fa-cube"></i></div>
                <div class="tile-title">Product Types</div>
                <div class="tile-desc">Manage product catalog</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('branch.warranties.new.index') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#fef3c7; color:#b45309;"><i class="fa fa-file-text-o"></i></div>
                <div class="tile-title">All Warranties</div>
                <div class="tile-desc">View global warranty list</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.profile.edit') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#fce7f3; color:#9d174d;"><i class="fa fa-user-circle"></i></div>
                <div class="tile-title">My Profile</div>
                <div class="tile-desc">Update your account details</div>
            </a>
        </div>
    </div>

    {{-- ── Recent System Warranties Table ────────────────────────────── --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="fa fa-clock me-2 text-primary"></i>Recent System Warranties
            </h6>
            <a href="{{ route('branch.warranties.new.index') }}" class="btn btn-outline-primary btn-sm px-3">
                View All <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            @if($recentWarranties->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-inbox fa-3x mb-3 d-block opacity-30"></i>
                    No warranties found in the system.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover admin-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Customer</th>
                                <th>Invoice</th>
                                <th>Dealer</th>
                                <th>Location</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th class="pe-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentWarranties as $warranty)
                                @php
                                    $ovStatus  = $warranty->overall_status;
                                    $rowClass  = match($ovStatus) {
                                        'modify'   => 'row-modify',
                                        'approved' => 'row-approved',
                                        'rejected' => 'row-rejected',
                                        default    => 'row-pending',
                                    };
                                    $pillLabel = match($ovStatus) {
                                        'modify'   => 'Modify Sent',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        default    => 'Pending',
                                    };
                                    $pillIcon  = match($ovStatus) {
                                        'modify'   => '✏️',
                                        'approved' => '✅',
                                        'rejected' => '❌',
                                        default    => '🕐',
                                    };
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="ps-3">
                                        <strong class="d-block">{{ $warranty->user->name ?? '—' }}</strong>
                                        <small class="text-muted">{{ $warranty->user->phone_number ?? $warranty->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $warranty->invoice_number }}</strong>
                                        <br><small class="text-muted">{{ $warranty->invoice_date?->format('d M Y') ?? '—' }}</small>
                                    </td>
                                    <td>{{ $warranty->dealer_name }}</td>
                                    <td>
                                        <span class="d-block">{{ $warranty->dealer_city }}</span>
                                        <small class="text-muted">{{ $warranty->dealer_state }}</small>
                                    </td>
                                    <td>
                                        @foreach($warranty->productDetails as $p)
                                            <span class="p-chip {{ $p->status }}">
                                                {{ $p->productType->name ?? '—' }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="s-pill {{ $ovStatus }}">
                                            {{ $pillIcon }} {{ $pillLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{ $warranty->created_at->format('d M Y') }}</span>
                                        <br><small class="text-muted">{{ $warranty->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="pe-3 text-center">
                                        <a href="{{ route('user.warranty.show', $warranty->id) }}"
                                           class="btn btn-sm btn-outline-primary px-3 fw-semibold">
                                            <i class="fa fa-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        @if($recentWarranties->hasPages())
        <div class="card-footer bg-white pt-3 pb-3">
            {{ $recentWarranties->links() }}
        </div>
        @endif
    </div>
</x-userdashboard-layout>
