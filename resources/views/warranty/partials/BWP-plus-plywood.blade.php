<link type="text/css" href="https://www.greenlamindustries.com/fonts/stylesheet.css" rel="stylesheet">
<style>
    body {
        font-family: swis721_wgl4_btroman !important;
    }

    .warranty-card {
        background: #FFFFFF;
        border:solid 1px #000;
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
.section-head {
    margin: 0 0 6px;
    font-size: 15px;
    line-height: 1.1;
    color: #000;
    font-weight: 800;
    display: flex;
    gap: 8px;
    align-items: baseline;}
p{    padding-left: 22px !important;}
    .warranty-card h2 {
        margin-top: 20px;
         /* font: 400 14px/20px swis721_wgl4_btroman; */
    }


    .roman-list {
    margin: 8px 0 10px;
    padding-left: 16px;
    list-style-type: lower-roman;
    display: grid;
    gap: 6px;
}


.warranty-card ul ul { padding-top: 8px;}
.warranty-card ul li{ padding-bottom: 5px;}
    .warranty-card p, .warranty-card ul li, .warranty-card ol li  {
        font: 400 14px/20px swis721_wgl4_btroman;
           padding-left: 0px;

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
        font-size: 22px;
        color: #f2592f; text-align: center;
    }

    #printButton{background: #333 !important;
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
  .miassk-img-box img {
         display: block;
         width: 100%;
         height: auto;
         object-fit: contain;
         }

  #printButton:hover{
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

  .h2title{ font-size: 22px !important; font-weight: bold !important;}

  table {
      width: 96%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #000;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    /* PRINT STYLE FIX */
    @media print {
      table, th, td {
        border: 1px solid black !important;
      }

      th, td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }
</style>
<div class="container">
    <div class="warranty-card">
        <div class="row">
            <table
                border="0"
                cellpadding="8"
                cellspacing="0"
                style="border:0px;"
            >
                <tbody>
                    <tr style="border:0px;">
                        <td
                            width="33%"
                            align="center"
                            colspan="3"
                            style="border:0px; text-align: center;"
                        >
                            <div class="miassk-img-box">
                                <img src="{{ asset('assets/images/BWP-Plus-Plywood.png') }}" alt="Mikasa Plywood">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <section class="sheet-inner">
                <h4 class="mt-5 wish-color">Terms & Conditions!</h4>
                <div class="columns">
                    <div>
                        <section class="section">
                                                      <p>Greenlam Industries Limited (the &ldquo;Company&rdquo;), the manufacturer/supplier of Mikasa Plywood (&ldquo;Product&rdquo;), offers {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} warranty to end users (&ldquo;End User&rdquo;) on Mikasa Plywood Blockboard MR (the &ldquo;Product&rdquo;), which shall come into effect from the date of purchase of the Product by the End User.</p>

                        </section>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">2</span>
                                Validity of the  {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }}  Warranty-
                            </h2>
                            <ul>
                                <li>
                                    The aforesaid warranty is provided against the Product, shall only be valid to cover the
                           manufacturing defects and damages to the Product due to insect attacks, subject to the
                           terms stated in Clause 5.
                                </li>
                                <li>The {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} warranty shall be only valid against the manufacturing defects.</li>
                                <li>The {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} aforesaid warranty is valid only towards the end user of the product and stands non-transferable to any other third party.</li>
                            </ul>
                        </section>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">3</span>
                                Liability of the Company-
                            </h2>
                            <p>
                                The liability of the company against the end user is limited to the extent of the
                        replacement of the damaged portion by new sheet of the same or similar product. The
                        company shall undertake any replacement upon satisfaction of the conditions stated in
                        Clause 6.
                            </p>
                        </section>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">4</span>
                                Complaint Procedure-
                            </h2>
                            <ul>
                                <li>
                                    The end user shall inspect the product promptly upon delivery, and if there is any
                           visible manufacturing defect in the product, that needs to be intimated to the company
                           within 30 days from the date of delivery, without any workmanship
                                </li>
                                <li>
                                    Any other manufacturing defect in the product shall be intimated by the end user to the
                           company within 30 days from the date of notice of the defect relating to the product
                           used.
                                </li>
                                <li>
                                    Any failure in giving a written notice of claim, by the end user within the aforesaid
                           timelines shall constitute a waiver by the end user of all claims in respect to such
                           Product(s).
                                </li>
                                <li>
                                    The complainant shall file a written notice of claim with the company, along with all the
                           necessary documents, including the purchase invoice, images of the defect in the
                           product, etc.
                                </li>
                                <li>
                                    The written notice of claim, along with the necessary documents, shall be sent by the
                           end user to the official email ID of the company, i.e.,
                                    <a href="mailto:info@mikasaply.com">info@mikasaply.com</a>
                                    .
                                </li>
                                <li>
                                    Upon receipt of the complaint from the end user, the company shall depute their
                           authorised representatives for a physical inspection of the allegedly damaged portion
                           of the product(s) at the place where it has been used by the end user.
                                </li>
                                <li>
                                    At the time of inspection, the end user shall be required to produce the proof of
                           purchase (original invoice) issued either by the company or its authorised dealer, to the
                           inspecting officer of the company.
                                </li>
                            </ul>
                        </section>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">5</span>
                                Rights of the Company-
                            </h2>
                            <ul>
                            <li>
                                The company retains all its rights to collect a sample of the damaged portion of the
                        product(s) and send it for examination to the following places at its sole discretion:
                            </li>
                            <ol class="alpha-list">
                                <li>
                                    Company's laboratory, and/or
                                </li>
                                <li>Any competent external laboratories.</li>
                            </ol>
                            <li>
                                Upon receiving satisfactory proof of the originality of the product based on physical
                        verification and/or chemical examination, the company shall replace the specific sheet
                        consisting of the portion proven to be defective or damaged.
                            </li>
                            <li>
                                For the purpose of clarification:
                        It shall be noted that the company shall undertake replacement against the damaged
                        portion of the product by new sheet of the same or similar product and not for the entire product line purchased by the end user, subject to the conditions provided in
                        Clause 4 and 5.
                            </li>
                            </ul>
                        </section>
                    </div>
                    <div>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">6</span>
                                Warranty Exclusions-
                            </h2>
                            <ul>
                                <li>
                                    Not withstanding anything mentioned in these terms and conditions, the company
                           provides a 20-year warranty for the product against manufacturing defects or insect
                           attack, subject to the below-mentioned conditions and exclusions:
                                </li>
                                <ol class="roman-list">
                                    <li>
                                        Misuse/abnormal use of the product, including but not limited to, close proximity of the
                              product to water or moisture or any other similar contingencies;
                                    </li>
                                    <li>
                                        Any defect arising due to a lack of proper maintenance, storage, or use of the product
                              in a severely pest-infected environment or inferior/bad workmanship
                                    </li>
                                    <li>
                                        Any other defect that may arise consequent to the violation/ignorance of the usage,
                              storage, and handling instructions provided by the company
                                    </li>
                                </ol>
                                <li>
                                    The company specifically excludes and shall not be responsible to pay any damages
                           for all/any consequential or physical damage to any product(s), commercial or
                           economic loss, including any direct, indirect, incidental, or consequential loss relating
                           thereto, whatsoever in nature.
                                </li>
                                <li>This warranty shall not be applicable in case:</li>
                                <ol class="roman-list">
                                    <li>
                                        Of normal wear and tear that naturally occurs due to normal use of the product, any
                              damage due to irregular use of the product, or due to any reason that is beyond the
                              control of the company, like an act of God, a natural calamity, fire, etc.;
                                    </li>
                                    <li>
                                        If the product is combined with any other brand of wood panel products or untreated
                              timber, and/or if the product has not been used and installed in accordance with
                              industry standards and best practises;
                                    </li>
                                    <li>
                                        If the product is mixed or used with any other product and the harm was caused by the
                              use of such other product with which the product was used;
                                    </li>
                                    <li>If the damage is to any other property/ life/person other than the product;</li>
                                    <li>If there is any breach of warranty condition(s) by the end user;</li>
                                    <li>
                                        If the end user fails to strictly adhere to the instructions or warning regarding improper
                              or incorrect usage of the product and/or is not diligent and/or has not taken all
                              measures to prevent any harm to the product;
                                    </li>
                                    <li>
                                        If the product has been back-engineered, misused, altered, or modified in a way that
                              changes the properties of the product by the end user or any other person, including
                              any seller, other than the company;
                                    </li>
                                    <li>
                                        If any other person, including the seller, has failed to exercise reasonable care in
                              assembling, inspecting, or maintaining such a product, including the warranty or
                              instructions of the company;
                                    </li>
                                    <li>
                                        If any other person, including the product seller, has made an express warranty
                              independent of that made by the company,
                                    </li>
                                    <li>
                                        If the product is used or installed under the influence of alcohol or any other
                              prescription drug that has not been prescribed by a medical practitioner
                                    </li>
                                    <li>
                                        The company shall only entertain claim for replacement, subject to the test certificate
                              from approved testing facilities, confirming the manufacturing defect and the visual,
                              chemical, and physical examinations confirming that the product is a genuine product
                              of the company.
                                    </li>
                                </ol>
                                <li>
                                    Customers are requested to check the image below for proper identification of products
                           manufactured/supplied by (Image of the front fascia of plywood is to be pasted below
                           for reference purposes).
                                </li>
                                <li>
                                    This warranty applies to all the warrantied products manufactured/supplied by the
                           company and used in India.
                                </li>
                            </ul>
                        </section>
                        <section class="section">
                            <h2 class="section-head">
                                <span class="num">7</span>
                                Jurisdiction of Courts-
                            </h2>
                            <ul>
                                <li>
                                    The Courts at New Delhi, India, shall have exclusive jurisdiction relating to any dispute
                           under this warranty.
                                </li>
                            </ul>
                        </section>
                        <div class="note">
                            <b>Note:</b>
                            Original invoices are required to be presented at the time of filing a complaint or claiming warranty.
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <div class="col-lg-6">
            <div class="section form-section">
                <h2 class="h2title">Purchase Details</h2>
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
                                <td>{{ $warrantyProduct->invoice_date ? $warrantyProduct->invoice_date->format('d-M-Y') : 'N/A' }}</td>
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
                                <td>
                                    {{ $warrantyProduct->date_of_issuance ? $warrantyProduct->date_of_issuance->format('d-M-Y') : 'N/A' }}
                                </td>
                            </tr>
                            {{--
                            <tr>
                                <th>Branch name:</th>
                                <td>{{ $warrantyProduct->branch_name }}</td>
                            </td>
                        </tr>
                        --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="col-lg-6">
        <div class="section form-section">
            <h2 class="h2title">Customer Details</h2>
            <div class="col-lg-6" style="50%;">
                <table>
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $warrantyProduct->registration->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $warrantyProduct->registration->user->address }}</td>
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
    <p style="text-align: center;">
        <strong>Note: This is a system generated certificate and no signature is required.</strong>
        <footer class="foot-bg" style="background: #efefef !important;">
            <p>
                <strong>Greenlam Industries Limited</strong>
                <br>
                2nd Floor, West Wing, Worldmark 1, Aerocity, IGI Airport Hospitality District, New Delhi – 110037,
                India
                <br>
                Tel:
                <a href="tel:(91) 11 42791399"> (91) 11 42791399</a>
                | Email:
                <a href="mailto:info@greenlam.com">info@greenlam.com</a>
                | Website:
                <a href="http://www.greenlam.com">www.greenlam.com</a>
            </p>
        </footer>
    </div>
</div>
{{--
</div>
--}}
