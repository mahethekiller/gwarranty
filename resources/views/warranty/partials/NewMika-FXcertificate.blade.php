<style>
    body {
        font-family: "Lexend", sans-serif !important;
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
        margin-top: 40px;
        margin-bottom: 40px;
    }
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
        margin-top: 0px;
        text-align: center;
        display: flex;
        margin-top: 40px;
    }


    #printButton:hover {
        background: transparent !important;
        font-size: 20px;
        color: #333 !important;
        border: solid 1px #333;
        padding: 5px 20px;
        border-radius: 5px;
        margin: 0px auto;
        margin-top: 0px;
        text-align: center;
        display: flex;
        margin-top: 40px;
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
    }
</style>
{{-- <div class="container"> --}}
    <div class="warranty-card">
        <div class="row">
            <table border="0" cellpadding="8" cellspacing="0" style="border:0px;">
                <tbody>
                    <tr style="border:0px;">
                        <td width="33%" align="center" style="border:0px; text-align: center;"><img src="{{ $logo }}" />
                        </td>
                        <td width="33%" align="center" style="margin-bottom:0px; border:0px; margin-top: 0px;">
                            <h1 style="margin-bottom:0px; text-align: center; margin-top: 0px;">WARRANTY CARD</h1>
                        </td>
                        <td width="33%" align="center" style="border:0px; text-align: center;"><img
                                src="{{ asset('assets/images/newmika-fx-logo.jpg') }}" /></td>
                    </tr>
                </tbody>
            </table>
            <div class="section">
                <h2 class="mt-5 wish-color">Congratulations!</h2>
                <p>On making a great choice choosing NewMika FX Exterior Grade Compact Panel. </p>
                <p>You have just purchased Exterior Grade Compact Panel of exceptional quality.
                    As much as they reflect beauty, their light fastness property, revolutionary NMEF technology and
                    protection layer reflect strength. Hence, making these irresistible exteriors last for long,
                    promising you {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of Warranty.</p>
                <p><strong>Promising you {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of
                        Warranty.</strong></p>
            </div>

            <div class="section">
                <h2>Limited Warranty</h2>
                <p>Greenlam Industries Limited (‘Greenlam’) expressly warrants that, it’s Exterior Grade Compact Panel,
                    NewMika FX (‘Product’) conform to applicable manufacturing standards and will be reasonably free of
                    defects in materials and workmanship for a period of {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} commencing from the date of issue of
                    invoice by the Company. This warranty shall automatically expire by efflux of time on completion of
                    the period indicated herein above and no notice of such expiry will be given by Greenlam. Colours
                    subject to dye lot variations. This limited warranty only applies to the product when stored,
                    handled, fabricated, and installed as recommended by Greenlam. Though the product may be put to
                    variety of uses and applications, Greenlam cannot warrant that the product will be fit for any
                    particular purpose and accordingly prior to use of the product the buyer should conduct its own test
                    to evaluate efficacy and suitability of the product for the intended use. Any damage caused by
                    accident, mishandling, tampering, negligence, alteration, misuse, fire, flood, earthquake, lighting
                    or any other act of God or natural calamities or lack of reasonable care are excluded from warranty.
                </p>
            </div>

            <div class="section">
                <h2>Disclaimer Of Warranties </h2>
                <p>Greenlam’s sole obligation for a remedy to the buyer shall be to repair or replace the defective
                    products, or at the option of greenlam, to refund the purchase price thereof. While we are pleased
                    to offer advice, we can not guarantee the finishing or fitness of the intended use. The warranties
                    set forth herein are the only warranties made by greenlam in connection with these products, and are
                    expressly in lieu of any other warranties, if any, express or implied.</p>
            </div>

            <div class="section">
                <h2>Limitation Of Liability</h2>
                <p>Only the original buyer of the product shall be entitled to claim under this warranty and the rights
                    under this warranty shall not be assignable by the original buyer. In no event the buyer shall be
                    entitled to claim an amount greater than the purchase price of the product in respect of which
                    damages are claimed and Greenlam shall not be liable to buyer or any third party for any special,
                    indirect, incidental, reliance, exemplary, or consequential damages or cover, or loss of profit,
                    revenue or use, in connection with, arising out of, or as a result of, the sale, delivery,
                    servicing, use or loss of use of the products sold hereunder.</p>
            </div>

            <div class="section">
                <h2>Inspection And Notice By Buyer </h2>
                <p>The buyer needs to inspect the product promptly upon delivery. Failure by buyer to give a written
                    notice of claim within 30 days from date of delivery regarding supply of defective products or
                    within 30 days from the date of notice of defect relating to the product used shall constitute a
                    waiver by the buyer of all claims in respect of such products. The buyer needs to provide all
                    relevant documents in averment of the claim. The Courts at New Delhi shall have exclusive
                    jurisdiction relating to any dispute under this warranty.</p>
            </div>

            <br><br>
            <div class="col-lg-6">
                <div class="section form-section">
                    <h2>Purchase Details</h2>
                    <div class="col-lg-6" style="50%;">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Invoice No.:</th>
                                    <td>{{ $warrantyProduct->registration->invoice_number }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice Date.:</th>
                                    <td>{{ $warrantyProduct->invoice_date ? $warrantyProduct->invoice_date->format('d-M-Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Execution Agency:</th>
                                    <td>{{ $warrantyProduct->execution_agency }}</td>
                                </tr>
                                <tr>
                                    <th>Dealer Name:</th>
                                    <td>{{ $warrantyProduct->registration->dealer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Total Quantity:</th>
                                    <td>{{ $warrantyProduct->total_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Handover Certificate:</th>
                                    <td>{{ $warrantyProduct->handover_certificate_date ? $warrantyProduct->handover_certificate_date->format('d-M-Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Issuance:</th>
                                    <td>{{ $warrantyProduct->date_of_issuance ?
                                        $warrantyProduct->date_of_issuance->format('d-M-Y') : 'N/A' }}
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
                    <div class="col-lg-6" style="50%;">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $warrantyProduct->registration->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>

                                        {{ $warrantyProduct->registration->user->address }},
                                        {{ $warrantyProduct->registration->user->city }},
                                        {{ $warrantyProduct->registration->user->state }},
                                        {{ $warrantyProduct->registration->user->pincode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $warrantyProduct->registration->user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $warrantyProduct->registration->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Product Name:</th>
                                    <td>{{ $warrantyProduct->product->name }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>




            <br>
    <p style="text-align: center;" > <strong>Note: This is a system generated certificate and no signature is required.</strong>
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
    </div>
    {{--
</div> --}}
