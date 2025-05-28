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
                        <a href="{{ route('dashboard') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('profile.edit') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('user.warranty.create') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/protection.png') }}" /></span>
                            <span class="pc-mtext">Warranty Registration</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('user.warranty.modify') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Modify Warranty Request</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('user.warranty.certificate') }}" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/download.png') }}" /></span>
                            <span class="pc-mtext">Download Certificates</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
