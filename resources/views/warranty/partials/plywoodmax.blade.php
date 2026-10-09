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

    ol.roman li {
        padding-left: 11px;
        margin-bottom: 8px;
        font-size: 17px;
        font-weight: 500;
        line-height: 161%;
        position: relative;
        list-style-type: upper-roman;
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
ol.alpha li {
    position: relative;
    padding-left: 4px;
    margin-bottom: 8px;
    font-size: 17px;
    font-weight: 500;
    line-height: 161%;
    list-style-type: lower-alpha;
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
                            <img src="{{ asset('assets/images/mikkas-plywood-img.jpg') }}" alt="Mikasa Plywood Max" style="max-width: 100%; height: auto;" />
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
                                    Greenlam Industries Limited (the "Company"), the manufacturer/supplier of Mikasa
                                    Plywood ("Brand"), offers a 15-year warranty to end users ("End User") on Mikasa
                                    plywood Max Plywood ("Product"), which shall come into effect from the date of
                                    purchase of the Product by the End User.
                                </p>

                                <p><strong>Promising you {{ !str_contains($warrantyProduct->warranty_years ?? '', 'year') && !str_contains($warrantyProduct->warranty_years ?? '', 'yr') ? ($warrantyProduct->warranty_years ?? '15') . ' years' : str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of
                                        Warranty.</strong></p>
                            </div>
                        </div>
                        <div class="warranty-section">
                            <div class="warranty-heading">
                                <span class="warranty-number">2</span>
                                <h2 class="warranty-title">
                                    Validity of the 15-Years Warranty
                                </h2>
                            </div>
                            <div class="warranty-content">
                                <ul class="warranty-list">
                                    <li>
                                        The aforesaid warranty is provided against the Product, shall only be valid to
                                        cover the manufacturing defects and damages to the Product due to insect
                                        attacks, subject to the terms stated in Clause 5.
                                    </li>
                                    <li>
                                        The 15-year warranty shall be only valid against the manufacturing defects.
                                    </li>
                                    <li>The 15-year aforesaid warranty is valid only towards the end user of the product
                                        and stands non-transferable to any other third party.</li>
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
                                <p class="intro-text">The liability of the company against the end user is limited to
                                    the extent of the replacement of the damaged portion by new sheet of the same or
                                    similar product. The company shall undertake any replacement upon satisfaction of
                                    the conditions stated in Clause 6.</p>
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
                                        The end user shall inspect the product promptly upon delivery, and if
                                        there is any visible manufacturing defect in the product, that needs to
                                        be intimated to the company within 30 days from the date of delivery,
                                        without any workmanship.
                                    </li>

                                    <li>
                                        Any other manufacturing defect in the product shall be intimated to
                                        the end user to the company within 30 days from the date of notice of
                                        the defect relating to the product used.
                                    </li>

                                    <li>
                                        Any failure in giving a written notice of the user within the aforesaid
                                        timelines constitutes a waiver by the end user of all claims in respect
                                        to such Product(s).
                                    </li>

                                    <li>
                                        The complainant shall file a written notice of claim with the company,
                                        along with all the necessary documents, including the purchase invoice,
                                        images of the defect in the product, etc.
                                    </li>

                                    <li>
                                        The written notice of claim, along with the necessary documents, shall
                                        be sent by the end user to the official email ID of the company,
                                        <a href="mailto:info@mikasa.in"><strong>info@mikasa.in</strong></a>
                                    </li>

                                    <li>
                                        Upon receipt of the complaint from the end user, the company shall
                                        depute their authorised representatives for a physical inspection of
                                        the allegedly damaged portion of product(s) at the place where it has
                                        been used by the end user.
                                    </li>

                                    <li>
                                        At the time of inspection, the end user shall be required to produce
                                        the proof of purchase (original invoice) issued either by the company
                                        or its authorised dealer, to the inspecting officer of the company.
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
                                <ul class="warranty-list exclusion-list">
                                    <li>
                                        The company retains all its rights to collect a sample of the damaged
                                        portion of the product(s) and send it for examination to the following
                                        places at its sole discretion:
                                    </li>
                                </ul>
                                <ol class="alpha">
                                    <li>Company's laboratory, and/or</li>
                                    <li>Any competent external laboratories.</li>
                                </ol>
                                <ul class="warranty-list exclusion-list">
                                    <li>
                                        Upon receiving satisfactory proof of the originality of the product based
                                        on physical verification and/or chemical examination, the company shall
                                        replace the specific sheet consisting of the portion proven to be defective
                                        or damaged.
                                    </li>
                                </ul>
                                <p class="intro-text">
                                    For the purpose of clarification:
                                </p>

                                <p class="intro-text">
                                    It shall be noted that the company shall undertake replacement against
                                    the damaged portion of the product by new sheet of the same or similar
                                    product and not for the entire product line purchased by the end user,
                                    subject to the conditions provided in Clause 4 and 5.
                                </p>
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
                                    Notwithstanding anything mentioned in these terms and conditions,
                                    the company provides a 15-year warranty for the product against
                                    manufacturing defects or insect attack, subject to the below-mentioned
                                    conditions.
                                </li>
                            </ul>
                            <ol class="roman">
                                <li>
                                    Misuse/abnormal use of the product, including but not limited to;
                                    close proximity of the product to water or moisture or any other
                                    similar conditions;
                                </li>

                                <li>
                                    Any defect arising due to a lack of proper maintenance, storage, or
                                    use of the product in a severely pest-infested environment or inferior
                                    /bad workmanship;
                                </li>

                                <li>
                                    Any other defect that may arise consequent to the violation/ignorance
                                    of the usage, storage, and handling instructions provided by the company.
                                </li>
                            </ol>
                            <ul class="warranty-list exclusion-list">
                                <li>
                                    The company specifically excludes and shall not be responsible to pay
                                    any damages for all any consequential or physical damage to any
                                    product(s), commercial or economic loss, including any direct,
                                    indirect, incidental, or consequential loss relating therewith,
                                    whatsoever in nature.
                                </li>

                                <li>
                                    This warranty shall not be applicable in case:
                                </li>
                            </ul>
                            <ol class="roman">
                                <li>
                                    Of normal wear and tear that naturally occurs due to normal use of
                                    the product, any damage due to irregular use of the product, or due
                                    to any reason other than the control of the company, like an act of
                                    God, a natural calamity, fire, etc.;
                                </li>

                                <li>
                                    If the product is combined with any other brand of wood panel products
                                    or untreated timber, and/or if the product has not been used and
                                    installed in accordance with industry standards and best practices;
                                </li>

                                <li>
                                    If the product is mixed or used with any other product and the harm
                                    was caused by the use of such other product with which the product
                                    was used;
                                </li>

                                <li>
                                    If the damage is to any other property/life/person other than the product;
                                </li>

                                <li>
                                    If there is any breach of warranty condition(s) by the end user;
                                </li>

                                <li>
                                    If the end user fails to strictly adhere to the instructions or warnings
                                    regarding improper use, storage of the product and/or use of it in
                                    violation of any terms and conditions;
                                </li>

                                <li>
                                    If the product has been engineered, misused, altered, or modified in
                                    a way that changes the properties of the product by the end user or
                                    any other person, including the company;
                                </li>

                                <li>
                                    If any other person, including the seller, has failed to exercise
                                    reasonable care in furnishing, inspecting, or maintaining such a
                                    product, including any product or installation instructions of the company;
                                </li>

                                <li>
                                    If any other person, including the product seller, has made an express
                                    warranty independent of that made by the company;
                                </li>

                                <li>
                                    If the product is used or installed under the influence of alcohol or
                                    any other prescription drug that has not been prescribed by a medical
                                    practitioner;
                                </li>

                                <li>
                                    The company shall only entertain claim for replacement, subject to the
                                    terms and conditions of the warranty, when the customer furnishes the
                                    certificate from approved testing facilities, confirming the manufacturing
                                    defect and the visual, chemical, and physical examinations confirming
                                    that the product is a genuine product of the company.
                                </li>
                            </ol>

                            <ul class="warranty-list">
                                <li>
                                    Customers are requested to check the image below for proper
                                    identification of products manufactured/supplied by the company.
                                    The front fascia of plywood is to be pasted below.
                                </li>

                                <li>
                                    This warranty applies to all the warranted products manufactured/supplied
                                    by the company and used in India.
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
                                    The Courts at New Delhi, India, shall have exclusive jurisdiction
                                    relating to any dispute under this warranty.
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
                <div class="col-lg-12">
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
                                <td>{{ $warrantyProduct->invoice_date ? ($warrantyProduct->invoice_date instanceof \DateTimeInterface ? $warrantyProduct->invoice_date->format('d-M-Y') : \Carbon\Carbon::parse($warrantyProduct->invoice_date)->format('d-M-Y')) : 'N/A' }}</td>
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
                                <td>{{ $warrantyProduct->date_of_issuance ? ($warrantyProduct->date_of_issuance instanceof \DateTimeInterface ? $warrantyProduct->date_of_issuance->format('d-M-Y') : \Carbon\Carbon::parse($warrantyProduct->date_of_issuance)->format('d-M-Y')) : 'N/A' }}</td>
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
                <div class="col-lg-12">
                    <table>
                        <tbody>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $warrantyProduct->registration->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>
                                    {{ implode(', ', array_filter([
                                        $warrantyProduct->registration->user->address,
                                        $warrantyProduct->registration->user->city,
                                        $warrantyProduct->registration->user->state,
                                        $warrantyProduct->registration->user->pincode
                                    ])) ?: 'N/A' }}
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
                                <td>{{ $warrantyProduct->product->name ?? 'Mikasa Ply' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <br>
        <p style="text-align: center;"> <strong>Note: Original invoices are required to be presented at the time of
                filing
                a complaint or claiming warranty</strong>
        <footer class="foot-bg" style="background: #efefef !important;">
            <p><strong>Greenlam Limited</strong><br>
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