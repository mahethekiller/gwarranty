<x-userdashboard-layout :pageTitle="'Dashboard'" :pageDescription="'Welcome to your Greenlam Warranty Portal'">
    @push('styles')
    <style>
        /* ── Design tokens ────────────────────────────────────── */
        :root {
            --c-modify:  #f59e0b;
            --c-pending: #3b82f6;
            --c-approved:#10b981;
            --c-rejected:#ef4444;
            --c-total:   #8b5cf6;
        }

        /* ── Hero welcome card ───────────────────────────────── */
        .hero-card {
            background: linear-gradient(135deg,#1e3a5f 0%,#0f6f5c 100%);
            border-radius: 16px; color:#fff; padding: 28px 32px;
            position: relative; overflow: hidden;
        }
        .hero-card::before {
            content:''; position:absolute; right:-40px; top:-40px;
            width:220px; height:220px; border-radius:50%;
            background: rgba(255,255,255,.06);
        }
        .hero-card::after {
            content:''; position:absolute; right:60px; bottom:-60px;
            width:160px; height:160px; border-radius:50%;
            background: rgba(255,255,255,.04);
        }
        .hero-card .greeting   { font-size:1.5rem; font-weight:700; }
        .hero-card .subtext    { font-size:.88rem; opacity:.8; margin-top:4px; }
        .hero-card .hero-badge {
            display:inline-flex; align-items:center; gap:6px;
            background:rgba(255,255,255,.18); border-radius:20px;
            padding:4px 14px; font-size:.78rem; font-weight:600;
            margin-top:14px; backdrop-filter:blur(4px);
        }

        /* ── Action-required banner ───────────────────────────── */
        .action-banner {
            border-left: 5px solid var(--c-modify);
            background: linear-gradient(135deg,#fffbeb,#fef3c7);
            border-radius: 12px; padding: 16px 20px;
            display: flex; align-items: center; gap: 14px;
            animation: pulse-left 2s infinite;
        }
        @keyframes pulse-left {
            0%,100% { border-left-color: var(--c-modify); }
            50%      { border-left-color: #d97706; }
        }

        /* ── Stat cards ──────────────────────────────────────── */
        .stat-card {
            border-radius: 14px; padding: 20px;
            display: flex; align-items: center; gap: 16px;
            border: 1px solid transparent;
            transition: transform .18s, box-shadow .18s;
            cursor: default;
        }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.1); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink:0;
        }
        .stat-num   { font-size: 2rem; font-weight: 800; line-height:1; }
        .stat-label { font-size: .75rem; color:#6b7280; font-weight:500; margin-top:3px; }

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

        /* ── Quick-action tiles ──────────────────────────────── */
        .quick-tile {
            border-radius: 14px; padding: 20px 18px;
            display: flex; flex-direction:column; gap: 8px;
            text-decoration: none; color: inherit;
            border: 1px solid #e5e7eb;
            transition: transform .18s, box-shadow .18s, border-color .18s;
        }
        .quick-tile:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,.1);
            border-color: #d1d5db;
            color: inherit; text-decoration: none;
        }
        .quick-tile .tile-icon {
            width: 44px; height: 44px; border-radius: 11px;
            display: flex; align-items:center; justify-content:center;
            font-size: 1.2rem;
        }
        .quick-tile .tile-title { font-weight: 600; font-size: .9rem; }
        .quick-tile .tile-desc  { font-size: .75rem; color:#9ca3af; }

        /* ── Recent table ────────────────────────────────────── */
        .recent-table th {
            font-size: .73rem; text-transform: uppercase;
            letter-spacing: .5px; color:#6b7280;
            font-weight: 600; background:#f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }
        .recent-table td { vertical-align: middle; }

        /* ── Status pills ────────────────────────────────────── */
        .s-pill {
            display:inline-flex; align-items:center; gap:4px;
            padding:3px 10px; border-radius:20px;
            font-size:.72rem; font-weight:600;
        }
        .s-pill.pending  { background:#dbeafe; color:#1e40af; }
        .s-pill.approved { background:#d1fae5; color:#065f46; }
        .s-pill.rejected { background:#fee2e2; color:#991b1b; }
        .s-pill.modify   { background:#fef3c7; color:#92400e; }

        /* ── Product chips ───────────────────────────────────── */
        .p-chip {
            display:inline-block; padding:2px 8px;
            border-radius:6px; font-size:.7rem; font-weight:500;
            background:#f3f4f6; color:#374151;
            border:1px solid #e5e7eb; margin:1px;
        }
    </style>
    @endpush

    @php $user = Auth::user(); @endphp

    {{-- ── Hero Card ─────────────────────────────────────────── --}}
    <div class="hero-card mb-4">
        <div class="greeting">👋 Welcome back, {{ $user->name }}!</div>
        <div class="subtext">Here's a snapshot of your Greenlam warranty registrations.</div>
        <div>
            <span class="hero-badge">
                <i class="fa fa-shield"></i> Greenlam Warranty Portal
            </span>
        </div>
    </div>

    {{-- ── Action-Required Banner ───────────────────────────── --}}
    @if($modify > 0)
    <div class="action-banner mb-4">
        <div style="font-size:2rem; flex-shrink:0">⚠️</div>
        <div class="flex-grow-1">
            <div class="fw-bold text-warning-emphasis mb-1">Action Required</div>
            <div style="font-size:.85rem; color:#78350f;">
                <strong>{{ $modify }} {{ Str::plural('warranty', $modify) }}</strong> need your attention.
                Please review the admin remarks and resubmit the corrected details.
            </div>
        </div>
        <a href="{{ route('user.warranties.index') }}" class="btn btn-warning btn-sm fw-semibold px-3 flex-shrink-0">
            <i class="fa fa-edit me-1"></i> Fix Now
        </a>
    </div>
    @endif

    {{-- ── Stats Row ────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <a href="{{ route('user.warranties.index') }}" class="stat-card card-total text-decoration-none d-flex">
                <div class="stat-icon icon-total"><i class="fa fa-th-large"></i></div>
                <div>
                    <div class="stat-num" style="color:#7c3aed;">{{ $total }}</div>
                    <div class="stat-label">Total Registered</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg">
            <div class="stat-card card-pending">
                <div class="stat-icon icon-pending"><i class="fa fa-hourglass-half"></i></div>
                <div>
                    <div class="stat-num" style="color:#1d4ed8;">{{ $pending }}</div>
                    <div class="stat-label">Under Review</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <a href="{{ route('user.warranties.index') }}" class="stat-card card-modify text-decoration-none d-flex" style="{{ $modify > 0 ? 'border-color:#fcd34d;box-shadow:0 0 0 3px rgba(245,158,11,.15);' : '' }}">
                <div class="stat-icon icon-modify"><i class="fa fa-edit"></i></div>
                <div>
                    <div class="stat-num" style="color:#b45309;">{{ $modify }}</div>
                    <div class="stat-label">Needs Modification</div>
                </div>
            </a>
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
                Quick Actions
            </h6>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('user.warranty.new.create') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#ede9fe; color:#7c3aed;"><i class="fa fa-plus-circle"></i></div>
                <div class="tile-title">New Registration</div>
                <div class="tile-desc">Register a new warranty</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('user.warranties.index') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#dbeafe; color:#1d4ed8;"><i class="fa fa-list-alt"></i></div>
                <div class="tile-title">My Warranties</div>
                <div class="tile-desc">View all registrations</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('user.warranties.certificates') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#d1fae5; color:#065f46;"><i class="fa fa-certificate"></i></div>
                <div class="tile-title">Certificates</div>
                <div class="tile-desc">Download approved certs</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('profile.edit') }}" class="quick-tile h-100">
                <div class="tile-icon" style="background:#fce7f3; color:#9d174d;"><i class="fa fa-user-circle"></i></div>
                <div class="tile-title">My Profile</div>
                <div class="tile-desc">Update your details</div>
            </a>
        </div>
    </div>

    {{-- ── Recent Warranties ──────────────────────────────────── --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="fa fa-clock me-2 text-primary"></i>Recent Registrations
            </h6>
            <a href="{{ route('user.warranties.index') }}" class="btn btn-outline-primary btn-sm px-3">
                View All <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            @if($recentWarranties->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-inbox fa-3x mb-3 d-block opacity-30"></i>
                    No registrations yet.
                    <a href="{{ route('user.warranty.new.create') }}" class="btn btn-primary btn-sm mt-3 d-block mx-auto" style="width:fit-content;">
                        <i class="fa fa-plus me-1"></i> Register Now
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover recent-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Invoice</th>
                                <th>Date</th>
                                <th>Dealer</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th class="pe-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentWarranties as $warranty)
                                @php
                                    $ovStatus = $warranty->overall_status;
                                    $pillLabel = match($ovStatus) {
                                        'modify'   => 'Modify Required',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        default    => 'Under Review',
                                    };
                                    $pillIcon = match($ovStatus) {
                                        'modify'   => '✏️',
                                        'approved' => '✅',
                                        'rejected' => '❌',
                                        default    => '🕐',
                                    };
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <strong>{{ $warranty->invoice_number }}</strong>
                                    </td>
                                    <td>
                                        <span>{{ $warranty->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td>{{ $warranty->dealer_name }}</td>
                                    <td>
                                        @foreach($warranty->productDetails as $p)
                                            <span class="p-chip">{{ $p->productType->name ?? '—' }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="s-pill {{ $ovStatus }}">
                                            {{ $pillIcon }} {{ $pillLabel }}
                                        </span>
                                    </td>
                                    <td class="pe-3 text-center">
                                        <a href="{{ route('user.warranty.show', $warranty->id) }}"
                                           class="btn btn-sm btn-outline-primary px-3">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($warranty->can_be_edited)
                                            <a href="{{ route('user.warranty.new.edit', $warranty->id) }}"
                                               class="btn btn-sm btn-warning px-3 ms-1 fw-semibold">
                                                <i class="fa fa-edit"></i> Fix
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-userdashboard-layout>
