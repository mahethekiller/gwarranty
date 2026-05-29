<!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar pc-sidebar-custom">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid logo-lg" alt="logo">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item {{ request()->routeIs('branch.warranties.new.*') ? 'active' : '' }}">
                        <a href="{{ route('branch.warranties.new.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Warranty Management</span>
                        </a>
                    </li>
                    <li class="pc-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile.edit') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>

                     @if (auth()->user()->hasRole('admin'))
                    <li class="pc-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">User Management</span>
                        </a>
                    </li>
                    <li class="pc-item {{ request()->routeIs('admin.product-types.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.product-types.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Product Types</span>
                        </a>
                    </li>
                    <li class="pc-item {{ request()->routeIs('admin.product-variants.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.product-variants.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Product Variants</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
