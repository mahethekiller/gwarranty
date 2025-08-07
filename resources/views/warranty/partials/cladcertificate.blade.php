<style>
    body {
        font-family: "Lexend", sans-serif !important;
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
<td width="33%" align="center" style="border:0px; text-align: center;"><img src="{{ asset('assets/images/greenlam-logo.png') }}" /></td>
<td width="33%" align="center" style="margin-bottom:0px; border:0px; margin-top: 0px;"><h1 style="margin-bottom:0px; text-align: center; margin-top: 0px;">WARRANTY CARD</h1></td>
<td width="33%" align="center" style="border:0px; text-align: center;"><img src="{{ asset('assets/images/Greenlam-clads-logo.jpg') }}" /></td>
</tr>
</tbody>
</table>
        <div class="section">
            <h2 class="mt-5 wish-color">Congratulations!</h2>
            <p>On making a superb choice for superb exteriors.</p>
            <p>You have just bought the finest Exterior Grade Compact Laminates. As much as they reflect beauty, their
                light fastness property, revolutionary GLE technology, and multi-protection layer reflect strength.
                Hence,
                irresistible exteriors resist for long.</p>
            <p><strong>Promising you {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of
                    Warranty.</strong></p>
        </div>

        <div class="section">
            <h2>Salient Features</h2>
            <ul>
                <li>Chemical Resistant</li>
                <li>Anti-Graffiti Property</li>
                <li>Fire Retardant</li>
                <li>Exclusive Range</li>
                <li>Complementing Hardware (Rivets)</li>
                <li>Light Fastness Property</li>
                <li>Environment Friendly Green DNA</li>
            </ul>
        </div>

        <div class="section">
            <h2>Storage</h2>
            <p>Storage of the panels on site should be horizontally on a flat wooden pallet under shade.</p>
        </div>

        <div class="section">
            <h2>Installation Guidelines</h2>
            <p>Box Section Size: </p>
            <ul>
                <li>38mmx38mmx2mm, and</li>
                <li>38mmx75mmx2mm (for area where two panels are joining)</li>
            </ul>
            <p>M.S. Brackets: Wind Load and Dead Load Brackets<br>
                Rivets: Greenlam Standard Rivets<br>
                Framing Distance: Max 600mm (façade), 450mm (soffit)<br>
                Rivet Distance: 450mm to 600mm<br>
                Gap Between Panels: Min 6mm (horizontal & vertical)<br>
                Fasteners: Standard as per requirement</p>
        </div>

        <div class="section">
            <h2>WARRANTY FOR GREENLAM CLADS</h2>
            <p>Greenlam provides a warranty for the Exterior Grade Compacts (“Product”) for a period of 12 years
                (“Warranty Period”) subject to the following
                terms and conditions:</p>
            <p class="note">Applicable only when installed on external building surfaces in India following company
                guidelines.</p>
        </div>

        <div class="section">
            <h2>Limitation</h2>
            <p>The limitation of the warranty being given herein is the sole warranty for the following purposes,
                excluding all other warranties, whether
                expressed or implied:</p>
            <ul style="list-style: none;">
                <li>a) The Product shall meet the applicable manufacturing standards</li>
                <li>b) The Product shall not delaminate for the Warranty Period specifically meaning that there shall be
                    no
                    separation between the plies and their bonds</li>
                <li>c) The colour and/or shine of the exterior surface of the Product may fade or lighten by exposure to
                    normal weather conditions of sun, rain and dust
                    within permissible limit as per international standard during the Warranty Period.</li>
            </ul>
            <p>The aforesaid warranties are subject to the condition that the Product is installed in the external
                surface
                of a building in India, strictly as per the
                instructions for installation as provided with the Product</p>
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
                                <th>Date of Issuance:</th>
                                <td>{{ $warrantyProduct->date_of_issuance ? $warrantyProduct->date_of_issuance->format('d-M-Y') : 'N/A' }}
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
        
        <div class="section">
            <h2>Exclusion of Warranty</h2>
            <p>Further, the warranty being provided by GREENLAM herein does not apply to the instances, including but
                not
                limited to the following:</p>
            <ul style="list-style: none;">
                <li>a) Any damage to the Product due to any defect in the walls, structure, foundation of the building
                    where
                    the Product is being installed</li>
                <li>b) Improper installation of the Product deviating from the strict instructions provided by GREENLAM
                </li>
                <li>c) Any damage to the Product due to causes other than normal weather conditions in the nature of
                    hailstorm, earthquake, fire, flood, tornado and
                    any other Act of God</li>
                <li>d) Any damage to the Product due to termite, mould, fungi, algae, bacteria, water seepage, rot,
                    decay in
                    the Product due to defects in the structure
                    of the building where the Product is being installed</li>
                <li>e) Any damage to the Product due to impact of foreign objects</li>
                <li>f) Any damage to the Product due to negligence, mishandling of the Product by the end user or his
                    agents
                </li>
                <li>g) Any use of the Product other than for the specific purposes for which it has been sold to the end
                    user</li>
                <li>h) Any damage to the Product due to improper storage by the end user</li>
                <li>i) Any act or omission or negligence or nuisance caused by any third party</li>
            </ul>
        </div>


        <div class="section">
            <h2>Liability of GREENLAM</h2>
            <p>In case of any defect or damage in the Product covered by the sole warranty being given herein, GREENLAM
                may replace the Product at its sole
                discretion, after being satisfied that the defect or damage is covered by the sole warranty. In case of
                such
                replacement being provided by
                GREENLAM, GREENLAM shall only be liable to provide a new Product for installation and shall not be
                liable:
            </p>
            <ul style="list-style: none;">
                <li>a) To pay for any costs of removal of the defective or damaged Product;</li>
                <li>b) To pay for any costs for re-installation of the new Product;</li>
                <li>c) To pay for any labour costs;</li>
                <li>d) To pay for any costs and/or replacement of the frame or structure or any hardware supporting the
                    Product.</li>
            </ul>
        </div>



        <div class="section">
            <h2>Notice</h2>
            <p>In the event that the end user notices any defect or damage in the Product which is expressly covered by
                the sole warranty herein, the end
                user shall be liable to intimate GREENLAM of such defect or damage within 30 days of the same.</p>
            <p>All claims or notices in this matter must be accompanied by the purchase invoice or receipt.</p>
            <p>GREENLAM shall inspect the claim and the end user shall not be entitled to make any repair or
                rectification
                to the Product pending such
                inspection.</p>
            <p>Within 30 days of inspection by GREENLAM, GREENLAM shall intimate its decision/report to the end user and
                the decision of GREENLAM in this
                regard shall be final and binding.</p>
            <p>In the event GREENLAM comes to the conclusion that the Product shall be replaced by itself, GREENLAM
                shall
                provide the new Product within
                30 days of intimating its decision/ report to the end user.</p>
            <p>For Greenlam Clad fading and delamination warranty only valid if installation was done according to
                company’s norms, as mentioned in the
                Installation Guidelines</p>
            <h2>Severability</h2>
            <p>In the event any term or part herein is held to be illegal, unenforceable or invalid, then said term or
                part shall be struck and all remaining terms
                shall remain in full force and effect.</p>
            <h2>Resolution of Disputes</h2>
            <p>The end user expressly agrees that all disputes or differences between the parties hereto arising out of
                or
                relating to the terms herein shall be
                referred to Arbitration before a sole Arbitrator to be nominated by GREENLAM. The provisions of the
                Arbitration and Conciliation Act, 1996 as
                amended from time to time, shall apply to the arbitration between the parties. The award of the
                Arbitrator
                shall be final and conclusive and
                binding upon the parties. The arbitration proceedings shall be conducted in English language and any
                award
                shall be rendered in English. The
                venue of arbitration shall be at New Delhi. The courts of Delhi and no other shall have exclusive
                jurisdiction over the matter.</p>
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
