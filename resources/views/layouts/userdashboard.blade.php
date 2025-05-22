@props([
    'pageTitle' => 'Greenlam Industries - Warranty Services Portal for Consumers',
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
    <title>Greenlam Industries - Warranty Services Portal for Consumers</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/style.css') }}" id="main-style-link">


</head>

<body>
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
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/dashboard.png') }}" /></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/user.png') }}" /></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/protection.png') }}" /></span>
                            <span class="pc-mtext">Warranty Registration</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/edit.png') }}" /></span>
                            <span class="pc-mtext">Modify Warranty Request</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><img src="{{ asset('assets/images/download.png') }}" /></span>
                            <span class="pc-mtext">Download Certificates</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
                            <span>Mukesh</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/avatar-icon.png') }}" alt="user-image"
                                            class="user-avtar wid-35">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Mukesh</h6>
                                        <span>UI/UX Designer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content" id="mysrpTabContent">
                                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                    aria-labelledby="drp-t1" tabindex="0">
                                    <a href="#!" class="dropdown-item">
                                        <img src="{{ asset('assets/images/edit-profile.png') }}" />
                                        <span>Edit Profile</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <img src="{{ asset('assets/images/view-profile.png') }}" />
                                        <span>View Profile</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
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
                            <h1>Warranty Registration</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="builder_contractor" class="form-label custom-form-label">Bought it for
                                yourself (Builder/Contractor?)</label>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="form-check form-check-inline">
                                        <input onclick="toggleDiv1(true)" class="form-check-input" type="radio"
                                            name="radio" id="radio-1" required>
                                        <label class="form-check-label" for="radio-1"> Yes </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input onclick="toggleDiv2(true)" class="form-check-input" type="radio"
                                            name="radio" id="radio-2" required>
                                        <label class="form-check-label" for="radio-2"> No </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12" id="targetDiv1" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <form action="">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="product_tpye" class="form-label custom-form-label">Product
                                                Tpye</label>
                                            <select class="form-select" id="mySelect" onchange="toggleDiv()">
                                                <option selected>Select Product Type</option>
                                                <option value="1">Mikasa Floors</option>
                                                <option value="mikasa_doors">Mikasa Doors</option>
                                                <option value="3">Mikasa Ply</option>
                                                <option value="4">Greenlam Clads</option>
                                                <option value="5">NewMikaFx</option>
                                                <option value="6">Greenlam Sturdo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="qty_purchased" class="form-label custom-form-label">Qty
                                                Purchased</label>
                                            <input class="form-control" id="qty_purchased" type="text"
                                                placeholder="Enter Qty Purchased">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="application_commercial_residential"
                                                class="form-label custom-form-label">Application
                                                (Commercial/Residential)</label>
                                            <input class="form-control" id="application_commercial_Residential"
                                                type="text"
                                                placeholder="Enter Application (Commercial/Residential)">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="place_of_purchase" class="form-label custom-form-label">Place
                                                of Purchase</label>
                                            <input class="form-control" id="place_of_purchase" type="text"
                                                placeholder="Enter Place of Purchase">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="invoice_number" class="form-label custom-form-label">Invoice
                                                Number</label>
                                            <input class="form-control" id="invoice_number" type="text"
                                                placeholder="Enter Invoice Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="upload_invoice" class="form-label custom-form-label">Upload
                                                Invoice</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="myDivMikasaDoors">
                                        <div class="form-group">
                                            <label for="upload_handover_certificate"
                                                class="form-label custom-form-label">Upload Handover
                                                Certificate</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <button class="custom-btn-blk">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-xl-12" id="targetDiv2" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <h6>“Please contact the builder/contractor for warranty”​</h6>
                            </div>
                        </div>
                    </div>
                </div>
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



    <script>
        function toggleDiv1(show) {
            document.getElementById('targetDiv2').style.display = 'none';
            document.getElementById('targetDiv1').style.display = show ? 'block' : 'none';
        }

        function toggleDiv2(show) {
            document.getElementById('targetDiv1').style.display = 'none';
            document.getElementById('targetDiv2').style.display = show ? 'block' : 'none';
        }

        function toggleDiv() {
            const select = document.getElementById("mySelect");
            const div = document.getElementById("myDivMikasaDoors");
            if (select.value === "mikasa_doors") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>


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
</body>
<!-- [Body] end -->

</html>
