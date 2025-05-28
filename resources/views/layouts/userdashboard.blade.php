@props([
    'pageTitle' => 'Dashboard',
    'pageDescription' => 'Greenlam Industries - Warranty Services Portal for Consumers',
    'pageScript' => null,
])
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mukesh">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/style.css') }}" id="main-style-link">


</head>

<body>
    @include('layouts.partials.usersidebar')
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <header class="pc-header pc-header-custom">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <img src="{{ asset('assets/images/menu-bar.png') }}" />
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <img src="{{ asset('assets/images/menu-bar.png') }}" />
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="{{ asset('assets/images/avatar-icon.png') }}" alt="user-image"
                                class="user-avtar">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/avatar-icon.png') }}" alt="user-image"
                                            class="user-avtar wid-35">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                        {{-- <span>UI/UX Designer</span> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content" id="mysrpTabContent">
                                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                    aria-labelledby="drp-t1" tabindex="0">
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <img src="{{ asset('assets/images/edit-profile.png') }}" />
                                        <span>Edit Profile</span>
                                    </a>
                                    {{-- <a href="#!" class="dropdown-item">
                                        <img src="{{ asset('assets/images/view-profile.png') }}" />
                                        <span>View Profile</span>
                                    </a> --}}
                                    <a href="{{ route('logout') }}" class="dropdown-item">
                                        <img src="{{ asset('assets/images/power-off.png') }}" />
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container pc-container-custom">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                            </ul>
                            <h1>{{ $pageTitle }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                {{ $slot }}
            </div>
        </div>


    </div>
    </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer pc-footer-custom">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">Copyright © 2025 Greenlam Industries Ltd. </p>
                </div>
            </div>
        </div>
    </footer>



    <script></script>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/customjs/common.js') }}"></script>  --}}
    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/dashboard/dashboard-default.js') }}"></script>

    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets/dashboard/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/pcoded.js') }}"></script>
    <script src="{{ asset('assets/dashboard/feather.min.js') }}"></script>
    @if ($pageScript)
        <script src="{{ asset('assets/customjs/' . $pageScript . '.js') }}"></script>
    @endif
</body>
<!-- [Body] end -->

</html>
