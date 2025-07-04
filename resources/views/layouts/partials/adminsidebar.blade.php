<!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar pc-sidebar-custom">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="#" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid logo-lg" alt="logo">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="{{ route('admin.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.warranty.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Warranty Management</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.profile.edit') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>


                     @if (auth()->user()->hasRole('admin'))
                    <li class="pc-item">
                        <a href="{{ route('admin.users.index') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">User Management</span>
                        </a>
                    </li>
                    @endif


                </ul>
            </div>
        </div>
    </nav>
