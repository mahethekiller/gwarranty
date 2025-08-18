<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mukesh">
    <title>Greenlam Clads – WARRANTY CARD</title>
    <!---<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Lexend", sans-serif !important;
        }

        .warranty-card {
            background: #FFFFFF;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
            border-radius: 20px;
            margin-top: 40px;
            padding: 30px;
            margin-bottom: 40px;
        }

        .warranty-card h2 {
            margin-top: 20px;
            font-size: 1.5rem;
        }

        .warranty-card p {
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
        }

        .warranty-card input[type="text"] {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 1px dotted #555;
            background: transparent;
            font-size: 16px;
            outline: none;
        }

        .foot-bg {
            background: #efefef;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
        }

        .warranty-card .wish-color {
            font-size: 45px;
            color: #116031;
        }
    </style>
</head>

<body>

    {{-- {{ dd($warrantyProduct) }} --}}


    <button id="printButton">Print</button>

    <div id="printArea">
        {{-- {{ $warrantyProduct->product_name }} --}}
        @if ($warrantyProduct->product_type == 4)
            @include('warranty.partials.cladcertificate')
        @elseif ($warrantyProduct->product_type == 6)
            @include('warranty.partials.sturdocertificate')
        @elseif ($warrantyProduct->product_type == 3)
            {{-- Mikasa ply  --}}
            @if ($warrantyProduct->product_name == 'Marine Blue Blockboard')
                @include('warranty.partials.blackbord-marineblue')
            @elseif ($warrantyProduct->product_name == 'Fire Guardian')
                @include('warranty.partials.fireGuardian')
            @elseif ($warrantyProduct->product_name == 'Marine Blue')
                @include('warranty.partials.marinebluecertificate')
            @elseif ($warrantyProduct->product_name == 'Marine')
                @include('warranty.partials.marinecertificate')
            @elseif ($warrantyProduct->product_name == 'MR+ Blockboard')
                @include('warranty.partials.blockboard-mr')
            @elseif ($warrantyProduct->product_name == 'MR+')
                @include('warranty.partials.mrcertificate')
            @elseif ($warrantyProduct->product_name == 'Sapphire')
                @include('warranty.partials.sapphire-certificate')
            @endif
        @elseif ($warrantyProduct->product_type == 5)
            @include('warranty.partials.NewMika-FXcertificate')
        @elseif ($warrantyProduct->product_type == 2)
            @include('warranty.partials.mikasadoorscertificate')
        @elseif ($warrantyProduct->product_type == 1)
            @if ($warrantyProduct->product_name == 'Atmos (10 mm)')
                @include('warranty.partials.mikasaAtmos')
            @elseif ($warrantyProduct->product_name == 'Pristine (15 mm)')
                @include('warranty.partials.mikasaPristine')
            @endif
        @endif

    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <script>
        $('#printButton').click(function() {
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // optional: reload page after print
        });
    </script>


</body>

</html>
