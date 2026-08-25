<link type="text/css" href="https://www.greenlamindustries.com/fonts/stylesheet.css" rel="stylesheet">


<style>
    body {
        font-family: swis721_wgl4_btroman !important;
    }

    .warranty-card {
        background: #FFFFFF;
        border: solid 1px #000;
        border-radius: 20px;
        margin-top: 40px;
        padding: 10px 20px;
        margin-bottom: 40px;
        max-width: 900px;
        margin: 0px auto;
        width: 100%;
        margin-top: 40px;
        margin-bottom: 40px;
    }


    .warranty-card h2 {
        margin-top: 20px;
        font: 400 23px/22px swis721_wgl4_btroman;
    }

    .warranty-card p {
        font: 400 18px/21px swis721_wgl4_btroman;
        color: #212121;
        font-weight: 500;
        line-height: 161%;
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

    .warranty-number {
        font-size: 24px;
        color: #111;
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

    .warranty-heading {
        display: flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 8px;
    }

    .warranty-list {}

    .warranty-list>li {
        position: relative;
        padding-left: 14px;
        margin-bottom: 8px;
        font-size: 17px;
        font-weight: 500;
        line-height: 161%;
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
                        {{-- <td width="33%" align="center" style="border:0px; text-align: center;"><img
                                src="{{ asset('assets/images/greenlam-logo.png') }}" /></td>
                        <td width="33%" align="center" style="margin-bottom:0px; border:0px; margin-top: 0px;">
                        </td> --}}
                        <td width="100%" align="center" style="border:0px; text-align: center;">
                            <img
                                src="{{ asset('assets/images/BmrChippp.jpg') }}" />
                                </td>
                    </tr>
                </tbody>
            </table>
            <div class="warranty-page">
                <h1 style="margin-bottom:0px; text-align: center; margin-top: 0px;">Terms & Conditions</h1>
                <div class="warranty-grid">
                    <div class="warranty-column">
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">1</span>
                                <h2 class="warranty-title">Introduction</h2>
                            </div>
                            <div class="warranty-content">
                                <p class="intro-text">
                                    Greenlam Limited, the manufacturer of Chipboard, offers a
                                    12-year warranty against manufacturing defects in the
                                    product. The warranty covers manufacturing defects and
                                    workmanship under normal conditions of use.
                                </p>

                                <p><strong>Promising you {{ str_replace('yrs', 'years',
                                        $warrantyProduct->warranty_years) }} of
                                        Warranty.</strong></p>
                            </div>
                        </div>
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">2</span>
                                <h2 class="warranty-title">
                                    Validity of the 12-year Warranty
                                </h2>
                            </div>
                            <div class="warranty-content">
                                <ul class="warranty-list">
                                    <li>
                                        he warranty shall be only valid against manufacturing defects.
                                    </li>
                                    <li>
                                        The warranty is valid only towards the User of the product and stands
                                        non-transferable
                                        to any other third party
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">3</span>
                                <h2 class="warranty-title">
                                    Liability of the Company
                                </h2>
                            </div>
                            <div class="warranty-content">
                                <ul class="warranty-list">
                                    <li>
                                        The maximum liability of the Company towards the User is limited to the extent
                                        of
                                        replacement of the damaged product (by a new board of the same product). The
                                        Company shall undertake any replacement upon satisfaction of the conditions
                                        stated
                                        herein below
                                    </li>
                                    <li>
                                        his warranty applies to the products manufactured/supplied by the Company and
                                        used in India.
                                    </li>
                                </ul>

                            </div>

                        </div>
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">4</span>
                                <h2 class="warranty-title">
                                    Complaint Procedure
                                </h2>
                            </div>
                            <div class="warranty-content">
                                <ul class="warranty-list">
                                    <li>
                                        The User shall inspect the product promptly upon delivery, and if there is any
                                        visible
                                        manufacturing defect in the product, that needs to be intimated to the Company
                                        within 30
                                        days from the date of delivery, without any workmanship.
                                    </li>

                                    <li>
                                        Any other manufacturing defect in the product shall be intimated by the User to
                                        the
                                        Company within 30 days from the date of notice of defect relating to the product
                                        used
                                    </li>

                                    <li>
                                        The User shall file a written document of claim with the Company, along with all
                                        the
                                        necessary documents, including the purchase invoice, images of the defect in the
                                        product, etc.
                                    </li>

                                    <li>
                                        Any failure in giving a written notice of claim by the User within the aforesaid
                                        timelines
                                        shall constitute a waiver by the User of all claims in respect of such
                                        product(s).
                                    </li>

                                    <li>
                                        The written notice of claim, along with the necessary documents, shall be sent
                                        by the
                                        User to the offcial email ID of the Company representative.
                                    </li>

                                    <li>
                                        Upon receipt of the complaint from the User, the Company may depute authorised
                                        representatives for a physical inspection within 7 working days from the
                                        acknowledgement of the complaint.
                                    </li>

                                    <li>
                                        At the time of inspection, the User shall be required to produce the proof of
                                        purchase
                                        (original invoice) issued either by the Company or its authorised
                                        dealer/distributor.
                                    </li>

                                </ul>

                            </div>

                        </div>
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">5</span>
                                <h2 class="warranty-title">
                                    Rights of the Company
                                </h2>
                            </div>
                            <div class="warranty-content">
                                <ul class="warranty-list">
                                    <li>
                                        The Company retains all its rights to collect samples of the damaged portion of
                                        the
                                        product(s) and send it for examination to the following places, at its sole
                                        discretion:
                                    </li>
                                    <div>
                                        <p> (a)    Company’s laboratory, and/or </p>
                                        <p> (b)    Any competent external laboratories or testing agencies. </p>
                                    </div>
                                    <li>
                                        Any competent external laboratories or testing agencies.
                                    </li>
                                    <li>
                                        Upon receiving satisfactory proof of the originality of the product based on
                                        physical
                                        verification and the genuineness of the complaint, the Company shall replace the
                                        quantity
                                        limited up to the defective quantity only as confirmed by the authorised
                                        representative of
                                        the Company
                                    </li>
                                    <li>
                                        For the purpose of clarification: It shall be noted that the Company shall
                                        undertake
                                        replacement against the damaged product by a new board of the same product and
                                        not for
                                        the entire product line purchased by the User
                                    </li>
                                    <li>
                                        The Company reserves the right to modify/alter the warranty policy/terms and
                                        conditions
                                        without any advance intimation.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="warranty-section">
                        <div class="warranty-heading">
                            <span class="warranty-number">6</span>
                            <h2 class="warranty-title">
                                Warranty Exclusions
                            </h2>
                        </div>
                        <div class="warranty-content">
                            <ul class="warranty-list exclusion-list">
                                <li>
                                    Not withstanding anything mentioned in these terms and conditions, the Company
                                    provides
                                    12 years warranty for the product against manufacturing defects, subject to the
                                    below-mentioned conditions/exclusions:
                                </li>

                                <li>
                                  Misuse/abnormal use of the product, including but not limited to close proximity of the
product to water or moisture or any other similar contingencies.
                                </li>
                                <li>
                                   Any defect arising due to lack of proper maintenance, storage or workmanship, or use of the
product in any unsuitable environment.
                                </li>
                                <li>
                                    Any other defect that may arise consequent to the violation/ignorance of the usage,
storage, and handling instructions provided by the Company.
                                </li>
                                <li>
                                   Normal wear and tear that naturally occurs due to normal use of the Product, normal ‘wear and
tear’, including without limitation, scratches, stains, wipe marks, chipping, dents, cuts on the
Product; any damage caused by misuse of the product, or any damage that is beyond the
control of the company, like an act of God, a natural calamity, fire, etc.
                                </li>
                                <li>
                                   If the product is combined with any other brand of wood or paper-based products or untreated
timber and/or the product has not been used and installed in accordance with industry
standards and best practices.
                                </li>
                                <li>
                                   Improper or incorrect substrate preparation, use of wrong, incorrect or expired adhesives,
incorrect application of adhesives, wrong selection or use of hardware, improper edge sealing
or improper joining of the product and its filling.
                                </li>

                                <li>
                                  Damage to any other property/life/person other than the product.
                                </li>
                                <li>
                                  Any discoloration or damage due to exposure to sunlight or outdoor application.
                                </li>
                                <li>
                                   If the User fails to strictly adhere to the installation instructions or warnings regarding improper
or incorrect usage of the product and/or is not diligent and/or has not taken all measures to
prevent any harm to the product.
                                </li>
                                <li>
                                   If any other person, including the product seller, has made an express warranty independent of
that made by the Company.
                                </li>
                                <li>
                                   The Company specifically excludes and shall not be responsible to pay any damages for
all/any consequential or physical damage to any product, commercial or economic loss,
including any direct, indirect, incidental, or consequential loss relating thereto, whatsoever in
nature.
                                </li>
                                <li>
                                   The Company shall only entertain claims for replacement, subject to the test certificate from
approved testing facilities confirming the manufacturing defect and the visual, chemical, and
physical examinations confirming that the product is a genuine product of the Company.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="warranty-section jurisdiction">
                        <div class="warranty-heading">
                            <span class="warranty-number">7</span>
                            <h2 class="warranty-title">
                               Jurisdiction of Courts
                            </h2>
                        </div>
                        <div class="warranty-content">
                            <ul class="warranty-list">
                                <li>
                                   The courts at New Delhi, India, shall have exclusive jurisdiction relating to any
dispute under this warranty.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br>
    <div class="col-lg-6">
        <div class="section form-section">
            <h2>Purchase Details</h2>
            <div class="col-lg-6" style="50%;">
                <table>
                    <tbody>
                        <tr>
                            <th>Serial No.:</th>
                            <td>{{ $warrantyProduct->serial_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Invoice No.:</th>
                            <td>{{ $warrantyProduct->registration->invoice_number }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Date:</th>
                            <td>{{ $warrantyProduct->invoice_date ? $warrantyProduct->invoice_date->format('d-M-Y')
                                : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Dealer Name:</th>
                            <td>{{ $warrantyProduct->registration->dealer_name }}</td>
                        </tr>
                        <tr>
                            <th>Total Quantity:</th>
                            <td>{{ $warrantyProduct->qty_purchased }}</td>
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
    <p style="text-align: center;"> <strong>Note: This is a system generated certificate and no signature is
            required.</strong>
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
{{-- </div> --}}