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

p{    padding-left: 22px !important;}
    .warranty-card h2 {
        margin-top: 20px;
         font: 400 14px/20px swis721_wgl4_btroman;
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
  margin-top: 40px;}


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
{{-- <div class="container"> --}}
<div class="warranty-card">
    <div class="row">
        <table border="0" cellpadding="8" cellspacing="0" style="border:0px;">
<tbody>
    <tr style="border:0px;">
<td width="33%" align="center" colspan="3" style="border:0px; text-align: center;"><img src="{{ asset('assets/images/blackbord-mrplus.jpg') }}" /></td>
</tr>

</tbody>
</table>
        <div class="section">
            <h4 class="mt-5 wish-color">Terms & Conditions!</h4>

<ol>
<li><strong>Greenlam Industries Limited</strong></li></ol>
<p>(the &ldquo;Company&rdquo;), the manufacturer/supplier of Mikasa Plywood (&ldquo;Product&rdquo;), offers {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} warranty to end users (&ldquo;End User&rdquo;) on Mikasa Plywood Blockboard MR (the &ldquo;Product&rdquo;), which shall come into effect from the date of purchase of the Product by the End User.</p>
<ol start="2"><li><strong>Validity of the {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} Warranty</strong></li>
</ol>
<ul>
<li>The aforesaid warranty is provided against the Product, shall only be valid to cover the manufacturing defects and damages to the Product due to insect attacks, subject to the terms stated in Clause 5.</li>
<li>The {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} warranty shall be only valid against the manufacturing defects.</li>
<li>The {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} aforesaid warranty is valid only towards the end user of the product and stands non-transferable to any other third party.</li>
</ul>
<ol start="3">
<li><strong><strong>Liability of the Company:</strong></strong></li>
</ol>
<ul>
<li>The liability of the company against the end user is limited to the extent of the replacement of the damaged portion (by/new sheet of the same or similar product). The company shall undertake any replacement upon satisfaction of the conditions stated in Clause 4.</li>
</ul>
<ol start="4">
<li><strong><strong>Complaint Procedure:</strong></strong></li>
</ol>
<ul>
<li>The end user shall inspect the product promptly upon delivery, and if there is any visible manufacturing defect in the product, that needs to be intimated to the company within 30 days from the date of delivery, without any workmanship.</li>
<li>Any other manufacturing defect in the product shall be intimated by the end user to the company within 30 days from the date of notice of the defect relating to the product purchased.</li>
<li>Any failure in giving a written notice of claim, by the end user within the aforesaid timelines shall constitute a waiver by the end user of all claims in respect to such Product(s).</li>
<li>The complainant shall file a written notice of claim with the company, along with all the necessary documents, including the purchase invoice, images of the defect in the product, etc.</li>
<li>The written notice of claim, along with the necessary documents, shall be sent by the end user to the official email ID of the company, i.e., <a href="mailto:info@mikasaply.com"><u>info@mikasaply.com</u></a>.</li>
<li>Upon receipt of the complaint from the end user, the company shall depute their authorised representatives for a physical inspection of the allegedly damaged portion of the product(s) at the place where it has been used by the end user.</li>
<li>At the time of inspection, the end user shall be required to produce the proof of purchase (original invoice) issued either by the company or its authorised dealer, to the inspecting officer of the company.</li>
</ul>
<ol start="5">
<li><strong><strong>Rights of the Company:</strong></strong></li>
</ol>
<ul>
<li>The company retains all its rights to collect a sample of the damaged portion of the product(s) and send it for examination to the following places at its sole discretion:
    <ul><li>Company&rsquo;s laboratory, and/or</li> <li>Any competent external laboratories.</li> </ul></li>
<li>Upon receiving satisfactory proof of the originality of the product based on physical verification and/or chemical examination, the company shall replace the specific sheet consisting of the portion proven to be defective or damaged.</li>
<li>For the purpose of clarification:<br />It shall not be liable that the company shall undertake replacement against the damaged portion of the product by new sheet of the same or similar product and not for the entire portion line purchased by the end user, subject to the conditions provided in Clause 4 and 5.</li>
</ul>
<ol start="6">
<li><strong><strong>Warranty Exclusions:</strong></strong></li>
</ol>
<ul>
<li>Notwithstanding anything mentioned in these terms and conditions, the company provides a {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} warranty for the product against manufacturing defects or insect attacks, subject to the below-mentioned conditions and exclusions:</li>
<li>Misuse/abnormal use of the product, including but not limited to, close proximity of the product to water or moisture or other similar contingencies, or<br />Any defect arising due to a lack of proper maintenance, storage or use of the product in any severely pest-infested environment or interior/bad workmanship.<br />Any other defect that may arise consequent to the violation/ignorance of the usage, storage, and handling instructions provided by the company.</li>
<li>The company specifically excludes and shall not be responsible to pay any damages for/all/any consequential or physical damage to any product(s), commercial loss or economic loss, including any direct, indirect, incidental, or consequential loss relating thereto, whatsoever in nature.</li>
<li>This warranty shall not be applicable in case:
    <ul>
    <li>Of normal wear and tear of the product(s), or due to normal use of the product, any damage due to irregular use of the product, or due to any reason that is beyond the control of the company, like an act of God, a natural calamity, fire, etc.</li>
    <li>If the product is combined with any other brand of wood panel products or untreated timber(s), and/or the product has not been used and installed in accordance with industry standards and best practices.</li>
    <li>If the product is mixed or used with any other product and the harm was caused by the usage of such another product with the product used.</li>
    <li>If there is any other warranty offered by/person other than the product.</li>
    <li>If the end user fails to strictly adhere to the instructions or warning regarding improper or incorrect usage of the product or is not aligned and/or has not taken all measures to prevent any harm to the product.</li>
    <li>If the product has been back/repanelled, misused, altered, or modified in a way which changes the properties of the product to be used at any other person, including any seller, other than the company.</li>
    <li>If any other person, including the seller, has failed to exercise reasonable care in transporting, inspecting, or maintaining such a product, including the workmanship or installations of the company.</li>
    <li>If any other person, including the product seller, has made an express warranty independent of that made by the company.</li>
    <li>If the product is used or installed under the influence of alcohol or any other prescription drug that has not been prescribed by a medical practitioner.</li>
    <li>The company shall only entertain claim for replacement, subject to the test certificate from approved testing facilities, confirming the manufacturing defect and the visual, chemical, and physical examinations confirming that the product is a genuine product of the company.</li>
  </ul>
</li>
<li>Customers are requested to check the image below for proper identification of products manufactured/supplied by (Image of the front fascia of plywood is to be pasted below for reference purpose).</li>
<li>This warranty applies to all the warrantied products manufactured/supplied by the company and used in India.</li>
</ul>
<ol start="7">
<li><strong><strong>Jurisdiction of Courts:</strong></strong></li>
</ol>
<ul>
<li>The Courts at New Delhi, India, shall have exclusive jurisdiction relating to any dispute under this warranty.</li>
</ul>

            <p><strong>Promising you {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of
                    Warranty.</strong></p>
        </div>




        </div>

        <div class="col-lg-6">
            <div class="section form-section">
                <h2 class="h2title">Purchase Details</h2>
                <div class="col-lg-6" style="50%;">
                    <table>
                        <tbody>
                            <tr>
                                <th>Invoice No.:</th>
                                <td>{{ $warrantyProduct->registration->invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>Invoice Date:</th>
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
                                <th>Date of Issuance:</th>
                                <td>{{ $warrantyProduct->date_of_issuance ? $warrantyProduct->date_of_issuance->format('d-M-Y') : 'N/A' }}
                                </td>
                            </tr>
                             <tr>
                                <th>Branch name:</th>
                                 <td>{{ $warrantyProduct->branch_name }}</td>
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


<br><br><br><br>
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
