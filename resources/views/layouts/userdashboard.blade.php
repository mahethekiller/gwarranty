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

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/ico" sizes="16x16">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    {{-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.14.2/dist/css/coreui.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <link rel="stylesheet" href="{{ asset('assets/dashboard/style.css') }}" id="main-style-link">


</head>

<body>


    <div style="display: none;" class="ajax-loader icon-spinner3" id="spinner">
        <div style="z-index: 9999; border: medium none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background-color: rgb(0, 0, 0); opacity: 0.6; cursor: wait; position: fixed;"
            class="blockUI blockOverlay"></div>
        <div style="z-index: 9999; position: fixed; padding: 0px; margin: 0px; width: 30%; top: 40%; left: 35%; text-align: center; color: rgb(0, 0, 0); cursor: wait;"
            class="blockUI blockMsg blockPage">
            <img alt="Loading" src="{{ asset('assets/images/loader.gif') }}" id="img-spinner">
        </div>
    </div>

    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('editor'))
        @include('layouts.partials.adminsidebar')
    @elseif(Auth::user()->hasRole('user'))
        @include('layouts.partials.usersidebar')
    {{-- @elseif(Auth::user()->hasRole('editor'))
        @include('layouts.partials.editorsidebar') --}}
    @endif
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
                            <img src="{{ asset('assets/images/avatar-icon.png') }}" alt="user-image" class="user-avtar">
                            <span>{{ Auth::user()->name }}</span>&nbsp;
                            <i aria-hidden="true" class="fa fa-angle-down"></i>

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
                    <p class="m-0">Copyright © {{ date('Y') }} Greenlam Industries Ltd. </p>
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


    <!-- Bootstrap Select compatible with Bootstrap 5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker({
                width: '100%'
            });
        });
    </script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- <script defer src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.14.2/dist/js/coreui.bundle.min.js"></script> --}}
    @if ($pageScript)
        <script src="{{ asset('assets/customjs/' . $pageScript . '.js') }}"></script>
    @endif
</body>
<!-- [Body] end -->

</html>
