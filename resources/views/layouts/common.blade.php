@props([
    'pageTitle' => 'Greenlam Industries - Warranty Services Portal for Consumers',
    'pageDescription' => 'Greenlam Industries - Warranty Services Portal for Consumers',
    'pageScript' => null,
])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ $pageTitle }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="author" content="Mukesh">
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/ico" sizes="16x16">
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/ico" sizes="16x16">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <header class="d-flex flex-wrap justify-content-center py-1 border-bottom align-items-center top-header">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
                <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" width="130px"
                    alt="Greenlam Industries - Warranty Services Portal for Consumers" />
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="#" class="nav-link custom-nav-btn">Contact Us</a></li>
            </ul>
        </header>
    </div>
    <div class="container-fluid p-0">
        <div class="banner">

            <figure class="figure">
  <img src="{{ asset('assets/images/banner.png') }}" class="img-fluid" alt="Greenlam Industries - Warranty Services Portal for Consumers" />
  <h1>Greenlam Industries</h1>
   <h2>Warranty Services Portal for Consumers</h2>
</figure>
            </div>
    </div>
    <div class="container">
        <main class="form-signin text-left">
            {{ $slot }}
        </main>
    </div>

    <div class="container-fluid">
        <section class="why-register-your-product">
            <div class="row">
                <h2>Why Register Your Product? </h2>
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="boxes">
                        <img class="img-fluid box-img" width="60px"
                            src="{{ asset('assets/images/Convenience-icon.png') }}" alt="">
                        <h3>For Your Convenience</h3>
                        <p>Gain quick and easy access to product manuals, replacement parts, tips and more.</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="boxes bg-darken">
                        <img class="img-fluid box-img" width="60px"
                            src="{{ asset('assets/images/Safety-icon.png') }}" alt="">
                        <h3>For Your Safety</h3>
                        <p>You are certain to be contacted in the unlikely event a safety notification is required.</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="boxes">
                        <img class="img-fluid box-img" width="60px"
                            src="{{ asset('assets/images/Warranty-icon.png') }}" alt="">
                        <h3>Warranty Service</h3>
                        <p>Obtain more efficient warranty service in case there is a problem with your product.</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="boxes bg-darken">
                        <img class="img-fluid box-img" width="60px"
                            src="{{ asset('assets/images/Ownership-icon.png') }}" alt="">
                        <h3>Confirmation Of Ownership</h3>
                        <p>Always have proof of purchase in case of an insurance loss (ex. fire, flood or theft).</p>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="container-fluid border-top">
        <section class="footer py-2">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <p>Copyright © {{ date('Y') }} Greenlam Industries Ltd.</p>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/common.js') }}"></script>
    {{-- Dynamically include page-specific script if available --}}
    @if ($pageScript)
        <script src="{{ asset('assets/customjs/' . $pageScript . '.js') }}"></script>
    @endif

</body>

</html>
