<link type="text/css" href="https://www.greenlamindustries.com/fonts/stylesheet.css" rel="stylesheet">

<style>
    body {
        font-family: swis721_wgl4_btroman, "Lexend", sans-serif !important;
    }

    .warranty-card {
        background: #FFFFFF;
        border: solid 1px #000;
        border-radius: 20px;
        margin-top: 40px;
        padding: 10px 20px;
        margin-bottom: 40px;
        max-width: 700px;
        margin: 0px auto;
        width: 100%;
    }

    .warranty-card h2 {
        margin-top: 20px;
        font: 400 14px/20px swis721_wgl4_btroman;
    }

    .warranty-card p {
        font: 400 14px/20px swis721_wgl4_btroman;
        color: #212121;
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
        background-color: #efefef !important;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
    }

    .warranty-card .wish-color {
        font-size: 45px;
        color: #116031;
    }

    #printButton {
        background: #333 !important;
        font-size: 20px;
        color: #fff !important;
        border: solid 1px #333;
        padding: 5px 20px;
        border-radius: 5px;
        margin: 0px auto;
        text-align: center;
        display: flex;
        margin-top: 40px;
        cursor: pointer;
    }

    #printButton:hover {
        background: transparent !important;
        color: #333 !important;
    }

    table {
        width: 96%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    /* PRINT STYLE FIX */
    @media print {
        table,
        th,
        td {
            border: 1px solid black !important;
        }

        th,
        td {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        #printButton {
            display: none !important;
        }
    }
</style>

<div class="warranty-card">
    <div class="row">
        <table border="0" cellpadding="8" cellspacing="0" style="border:0px;">
            <tbody>
                <tr style="border:0px;">
                    <td width="33%" align="center" style="border:0px; text-align: center;">
                        <img src="{{ asset('assets/images/greenlam-logo.png') }}" alt="Greenlam Logo" />
                    </td>
                    <td width="33%" align="center" style="margin-bottom:0px; border:0px; margin-top: 0px;">
                        <h1 style="margin-bottom:0px; text-align: center; margin-top: 0px; font-size: 24px;">WARRANTY CARD</h1>
                    </td>
                    <td width="33%" align="center" style="border:0px; text-align: center;">
                        <img src="{{ asset('assets/images/greenlam-logo.png') }}" alt="Greenlam Logo" />
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="section">
            <h2 class="mt-5 wish-color">Congratulations!</h2>

            <p>Greenlam Industries Limited expressly warrants that its product <strong>‘Greenlam HMR’{{ !empty($warrantyProduct->variant_name) ? ' (' . $warrantyProduct->variant_name . ')' : '' }}</strong> is reasonably free of defects
                in material and workmanship, and when properly handled and fabricated will conform, within accepted
                tolerances, to applicable manufacturing specifications as set forth in our technical brochure.</p>

            <p>Greenlam Industries Limited provides warranty to the original buyer for a period of <strong>{{ str_replace('yrs', 'Years', $warrantyProduct->warranty_years ?? '12 Years') }}</strong> from the date of shipment / invoice of Greenlam HMR and
                shall not be assignable by the original buyer.</p>

            <p><strong>Promising you {{ str_replace('yrs', 'Years', $warrantyProduct->warranty_years ?? '12 Years') }} of Warranty.</strong></p>
        </div>

        <div class="section">
            <p>This warranty does not cover damage resulting from accident, misuse, alteration, abuse, improper storage,
                handling, workmanship, or lack of reasonable care.</p>

            <p>Due to the variety of uses and applications to which this product may be put, and because the
                manufacturer has no control over such aspects, the warranty set forth above is exclusive and in lieu of
                all other warranties, if any, expressed or implied, in fact or by operation of law or otherwise, or
                arising by course of dealing or performance, custom or usage in the trade, including, without
                limitation, the implied warranties of fitness for a particular purpose and merchantability.</p>

            <p>The buyer’s sole and exclusive remedy for any noncompliance with the warranty set forth above shall
                be limited to repair or replacement of the defective product, or, in the event that repair or
                replacement is not feasible, return of the defective product or refund of the purchase price thereof.
            </p>
            <p>Under no circumstances shall the manufacturer be liable in excess of the purchase price of the defective
                product, in either tort or contract or otherwise, for any loss, damage, or injury in connection with or
                arising from the purchase, use, or inability to use this product, or for any special, indirect,
                collateral, incidental, consequential or exemplary damages.</p>
            <p>The buyer needs to inspect the product promptly upon delivery. Failure by buyer to give a written notice
                of claim within 30 days from date of delivery regarding supply of defective products or within 30 days
                from the date of notice of defect relating to the product used shall constitute a waiver by the buyer of
                all claims in respect of such products.</p>

            <p>Please retain all original documents to enable Greenlam’s authorized person to verify your claim
                and to expedite the resolution thereof.</p>
        </div>
    </div>

    <br><br>
    <div class="col-lg-6">
        <div class="section form-section">
            <h2>Purchase Details</h2>
            <div class="col-lg-6" style="width: 100%;">
                <table>
                    <tbody>
                        <tr>
                            <th>Serial No.:</th>
                            <td>{{ $warrantyProduct->serial_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Invoice No.:</th>
                            <td>{{ $warrantyProduct->registration->invoice_number ?? ($warrantyProduct->invoice_number ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Date:</th>
                            <td>
                                @if (!empty($warrantyProduct->invoice_date))
                                    {{ is_string($warrantyProduct->invoice_date) ? \Carbon\Carbon::parse($warrantyProduct->invoice_date)->format('d-M-Y') : $warrantyProduct->invoice_date->format('d-M-Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dealer Name:</th>
                            <td>{{ $warrantyProduct->registration->dealer_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Product Variant:</th>
                            <td>{{ $warrantyProduct->variant_name ?? 'Greenlam HMR' }}</td>
                        </tr>
                        <tr>
                            <th>Total Quantity:</th>
                            <td>{{ $warrantyProduct->qty_purchased ?? ($warrantyProduct->total_quantity ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>Date of Issuance:</th>
                            <td>
                                @if (!empty($warrantyProduct->date_of_issuance))
                                    {{ is_string($warrantyProduct->date_of_issuance) ? \Carbon\Carbon::parse($warrantyProduct->date_of_issuance)->format('d-M-Y') : $warrantyProduct->date_of_issuance->format('d-M-Y') }}
                                @else
                                    {{ date('d-M-Y') }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br><br>
    <div class="col-lg-6">
        <div class="section form-section">
            <h2>Customer Details</h2>
            <div class="col-lg-6" style="width: 100%;">
                <table>
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $warrantyProduct->registration->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>
                                {{ $warrantyProduct->registration->user->address ?? '' }}
                                @if(!empty($warrantyProduct->registration->user->city)), {{ $warrantyProduct->registration->user->city }}@endif
                                @if(!empty($warrantyProduct->registration->user->state)), {{ $warrantyProduct->registration->user->state }}@endif
                                @if(!empty($warrantyProduct->registration->user->pincode)) - {{ $warrantyProduct->registration->user->pincode }}@endif
                            </td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $warrantyProduct->registration->user->phone_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $warrantyProduct->registration->user->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Product Name:</th>
                            <td>{{ $warrantyProduct->product->name ?? 'Greenlam HMR' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>
    <p style="text-align: center;"><strong>Note: This is a system generated certificate and no signature is required.</strong></p>
    <footer class="foot-bg" style="background: #efefef !important;">
        <p><strong>Greenlam Industries Limited</strong><br>
            2nd Floor, West Wing, Worldmark 1, Aerocity, IGI Airport Hospitality District, New Delhi – 110037,
            India<br>
            Tel: <a href="tel:(91) 11 42791399"> (91) 11 42791399</a> | Email: <a
                href="mailto:info@greenlam.com">info@greenlam.com</a> | Website: <a
                href="http://www.greenlam.com">www.greenlam.com</a>
        </p>
    </footer>
</div>
