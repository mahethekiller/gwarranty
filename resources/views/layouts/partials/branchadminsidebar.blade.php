<!-- [ Branch Admin Sidebar ] -->
    <nav class="pc-sidebar pc-sidebar-custom">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('branch.dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid logo-lg" alt="logo">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">

                    {{-- Dashboard --}}
                    <li class="pc-item {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('branch.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    {{-- Warranty Management --}}
                    <li class="pc-item {{ request()->routeIs('branch.warranties.new.*') ? 'active' : '' }}">
                        <a href="{{ route('branch.warranties.new.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Warranty Management</span>
                        </a>
                    </li>

                    {{-- My Profile --}}
                    <li class="pc-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile.edit') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
