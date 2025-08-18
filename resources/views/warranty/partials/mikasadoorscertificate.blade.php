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
                    <td width="33%" align="center" style="border:0px; text-align: center;"><img
                            src="{{ $logo }}" /></td>
                    <td width="33%" align="center" style="margin-bottom:0px; border:0px; margin-top: 0px;">
                        <h1 style="margin-bottom:0px; text-align: center; margin-top: 0px;">WARRANTY CARD</h1>
                    </td>
                    <td width="33%" align="center" style="border:0px; text-align: center;"><img
                            src="{{ $greenlamCladsLogo }}" /></td>
                </tr>
            </tbody>
        </table>
        <div class="section">
            <h2 class="mt-5 wish-color">Congratulations!</h2>
            <p>Mikasa warranty terms and conditions  and commercial flooring  maintenance guidelines with 5 years limited warranty.</p>
            <p>Mikasa commercial flooring is covered by a 5-year limited warranty for all approved commercial uses. However, coverage may be lost due to failure to strictly follow all installation and maintenance instructions and recommendations or the use of improper materials, tools non mikasa brand underlayment, flooring accessories, cleaners, tools, etc. Read and follow all mikasa installation and maintenance instructions carefully. The 5-year limited warranty applies only to mikasa 15mm, and the 3 year limited warranty for 10mm flooring. Both warranties cover only such products purchased on or after the date set forth above. The warranty is not transferable and it extends only to the original product and after following the installation guidelines. All warranties expire upon sale, transfer or relocation of the installed product or installation location.</p>
            <p><strong>Promising you {{ str_replace('yrs', 'years', $warrantyProduct->warranty_years) }} of
                    Warranty.</strong></p>
        </div>

        <div class="section">
            <h2>Approved Commercial Uses</h2>
            <p>Mikasa commercial flooring may be used as a floor covering  public or private business, educational or religious buildings and offices. All areas must be environmentally controlled prior to, during, and  after installation. Excluded are those facilities used as tap dance studios, golf club areas where spikes are worn, and other locations where metal
cleats may be used.</p>
        </div>

        <div class="section">
            <h2>Installation Warranty</h2>
            <p>We warranty our floor installations for long-lasting performance. This full 5 year limited warranty applies to 15mm flooring, and the 3 year limited warranty applies to 10mm flooring, provided that the instructions are followed and our floors are installed according to Mikasa guidelines (see Mikasa Commercial Installation Guide) using Mikasa branded application
products. See Exclusions and Liability Limitations below for other exclusions and limitations of this warranty.</p>
        </div>

        <div class="section">
            <h2>Visual Appearance Warranty</h2>
            <p>Each plank of Mikasa  flooring is carefully inspected by our quality control personnels  to ensure they are defect free. In the unlikely event that you encounter a visually defective plank prior to its installation, company will replace it free of charge. Simply return it with your receipt to your retailer for your free replacement. This warranty does not extend to cover flooring after installation. See Exclusions and Liability Limitations below for other exclusions and limitations of this warranty.</p>
        </div>

        <div class="section">
            <h2>Structural Warranty</h2>
            <p>We extend our warranty to cover the structural integrity of every board. All of our hardwood flooring is processed by using a sophisticated bonding system with each plank constructed under intense heat and pressure to ensure quality. In the unlikely event that the bonding or other structural aspect of a plank fails within the first year following installation, we will either repair or replace the defective plank free of charge. If failure occurs after one year  installation, we will replace the defective plank, exclusive of the costs of removal, reinstallation or refinishing. See Exclusions and Liability Limitations below.</p>
        </div>

        <div class="section">
            <h2>Moisture Protection Warranty</h2>
            <p>Our floors are specifically designed to withstand the effects of normal moisture or dryness in a climate-controlled environment. They are built with a cross-layered base, making them extremely stable. In fact, MIKASA flooring products are 75% more resistant to expansion and contraction than traditional solid hardwood floors. If installed and maintained in strict accordance with our instructions, we warranty our floors against damage caused by normal moisture or arid conditions as defined in. Should our flooring fail under normal moisture conditions, we will, at the first instance repair the product if the repair is not advisible by our technical team then we will , replace the damaged flooring, exclusive of the
costs of refinishing, one time. See Exclusions and Liability Limitations below for other exclusions and limitations of this warranty. </p>
        </div>

        <div class="section">
            <h2>Wear Through Warranty</h2>
            <p>Mikasa uv coating finishes are warranted not to wear through to the bare wood for 5 years, from the date of  purchase. This warranty extends only for wear areas which cover at least ten percent (10%) of the surface area of the installed mikasa floor. Should our flooring wear under normal use conditions, we will, at the first instance repair the product if the repair is not advisible by our technical team then we will repalce,  the damaged flooring, exclusive of the costs of refinishing, one time. Gloss reduction and scratches in the finish are not considered surface wear and are not covered under this warranty.  See exclusions and liability limitations below for other exclusions and limitations of this warranty.</p>
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
                                <th>Invoice Date:</th>
                                <td>......................</td>
                            </tr>
                            <tr>
                                <th>Date of Handover Certificate:</th>
                                <td>......................</td>
                            </tr>
                            <tr>
                                <th>Product Thickness:</th>
                                <td>......................</td>
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
                                <th>Project Location:</th>
                                <td>......................</td>
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
            <h2>Exclusion</h2>
            <p>Mikasa warranties described above will be voided and MIKASA will not in any way be liable under said warranties or otherwise in the event of:</p>
            <ul>
                <li>a) Improper Installation. Performance of the flooring is highly dependent upon proper installation. Flooring that has been installed with visible manufacturing defects will void the warranty. Accordingly, installation must be in strict accordance with the instructions and recommendations found in the MIKASA Installation Guide including the use of only MIKASA branded accessories.</li>

<li>b) Improper Maintenance. Maintenance must be in strict accordance with the instructions and recommendations found in the MIKASA Commercial Flooring and Maintenance Procedures including the use of only MIKASA branded accessories.</li>

<li>c)  Normal Environmental Conditions. Our products are warranted to perform in what we consider to be normal applications. Any exposure to excessive heat or moisture may cause damage to the flooring and is not covered by this warranty regardless of the cause or source. Damage caused by environmental conditions outside of tolerance specified are excluded from any and all warranty coverage.</li>

<li>d) Misuse. As well as we make our flooring, MIKASA does not warranty its flooring against normal wear and tear, nor does it warranty its flooring against damage caused directly or indirectly by misuse, abuse, accident or use that is not consistent with MIKASA procedures. Accordingly, no warranty is provided for any damage due to inadequate care or other causes noted including, but not limited to, stains, worn or narrow-heeled shoes, spike shoes that worn at Golf Club area, furniture or equipment movement, damage caused by heavy items or by impact, scratches or scarring caused by pets, or abrasive, sharp or pointed items, moisture damage caused by wet mopping, spills, standing water, or damaged caused by any type of tape applied to the floor.</li>

<li>e) Alterations/Repairs. Alterations to any MIKASA product will void any and all express or implied warranties, including merchantability or fitness for particular purpose. No warranty is provided to cover repairs or resurfacing (unless and only to the extent performed under warranty by MIKASA), and repairs or replacement (even if by MIKASA) shall not extend the warranty period.</li>

<li>f) Reinstallation. In the event that MIKASA decide to replace or reinstall warranted planks, MIKASA shall in no manner be obligated to  incur the costs of moving or removing fixtures or other objects affixed to the flooring, nor shall it be obligated to incur the costs of removing or re-installing the defective flooring or resurfacing or refinishing the replaced or surrounding flooring, except, and to the extent expressly provided in the Warranty Description, above. No obligation to replace or repair shall extend to any subfloor materials, adhesives, supplies or other items consumed in the course of removal, installation or refinishing.</li>

<li>g) Normal Variances. Wood is a natural and living product and variations in color, grain pattern and/or texture normally occur in the original materials  and no warranty shall apply thereto. Installed flooring will change in coloration over time and this is also a natural characteristic of wood products for which no warranty is provided. Exposure to direct sunlight or partial exposure (e.g. area rug or furniture placement) may cause variations in color or affect the uniformity of the natural coloration changes and this is not covered by any warranty.</li>
            </ul>
        </div>


        <div class="section">
            <h2>Liability</h2>
            <p>Commercial Warranty - for commercial applications involving light to normal traffic conditions. No products in industrial or commercial applications, except as stated herein, no other warranty, expressed or implied, is provided, including any warranty of fitness for a particular purpose.
            </p>
            <p>The above statement of warranty is the only warranty provided by MIKASA for its name  commercial flooring products. This warranty is exclusive and in lieu of any and all other warranties whether oral or written, or express or implied, MIKASA also specifically disclaims any and all implied warranties, including without limitation, warranties of merchantability or fitness for a particular purpose. No retailer, installer, dealer, distributor, agent or employee has authority to increase the scope or alter the terms or coverage of this warranty. No agreement to repair or replace shall in any event act to extend the period of coverage of any warranty provided. In no event shall MIKASA be liable or in any manner responsible for any claim, loss or damage arising from the purchase, use or inability to use its products or from any form of special, indirect, incidental, or consequential damages, including, without limitation, lost profits, emotional, multiple, punitive or exculpatory damages (see below) or attorneys fees, even if MIKASA or its representatives have been advised of the possibility of such damages before sale. In no event shall MIKASA be obligated to cover the costs of old or new materials other than MIKASA Brand flooring products (such as glue and etc.), even if recommended by MIKASA and any warranty thereto is limited to that, if any, provided by the original manufacturer. In no event shall MIKASA’s liability, under this warranty or otherwise, exceed the amount MIKASA actually received upon distribution for the defective materials at issue. Any claim for warranty coverage must be made within one year of the date upon which the defect first became known. All claims must be made in writing and sufficiently documented (photos, etc.), initiated by selling retailer and distributor. Please note that in order to make any claim under this warranty, evidence of the purchase date and the identity of the original purchaser and installation location must be provided and without such proof, no warranty coverage will apply. We strongly suggest that you keep this information together and your receipt in a safe and secure location. Please note, you and your installer are responsible to inspect flooring prior to installation. We accept no responsibility for liabilities, claims, or expenses, including labour costs, where flooring with visible defects has been installed.</p>

<p>We reserve the right to verify any claims or defect by inspection and have samples removed for technical analysis.</p>

<p>This warranty gives you specific legal rights and you may have other rights which may vary from state to state. Some states do not allow the exclusion or limitation of implied warranties or incidental, consequential, emotional distress or punitive damages and in such event, the exclusions and limitations set forth above shall be construed and enforced to the fullest extent possible by the laws of any such state. Accordingly, some of the above limitations may not apply to you.</p>
        
<p>Except as stated herein, no other warranties shall apply.</p>
</div>



        <div class="section">
            <h2>Mikasa Commercial Flooring Maintenance Procedures For 10mm And 15mm Uv Cured Acrylic Factory Pre-finished Flooring</h2>
            <p>Installation:</p>
<p>Read and follow all installation instructions for the installation method selected (Float, Glue or Nail), found in the MIKASA Installation Guide available on our website (kahrs.com.</p>
<p>Maintenance:</p>
<p>Immediately: Wipe up spills or spots with a lightly damp cloth.</p>
<p>Frequently: Vacuum or sweep your floor daily to prevent dirt, dust and grit from scratching or dulling its finish.</p>
<p>Periodically: See MIKASA Commercial Flooring Maintenance Procedures for</p>
<p>details.</p>
<p>Added Protection:</p>
<p>Because wood is a product of nature, it can be dented or scratched by sharp appliances and heavy loads on furniture legs. Some furniture manufacturers place small-bearing metal or plastic domes, or hard rollers on furniture legs that can cause damage to wood flooring,</p>
<p>including MIKASA flooring products.</p>
<p>To avoid or eliminate such damage use wide-bearing and non-staining glides and casters and place floor Protectors beneath the feet of all furniture legs and use floor guards under all rolling furniture.</p>
<p>Do:</p>
<ul>
<li>Support furniture and heavy appliances with wide-bearing, nonstaining glides or casters.</li>
</ul>
<ul>
<li>Move appliances and furniture into place by sliding them slowly over the floor on a piece of plywood or masonite with the smooth side down.</li>
</ul>
<ul>
<li>Place a quality door mat at the entrance areas to help protect your floor from abrasive dust and grit and to help save unnecessary clean-up tasks.</li>
</ul>
<ul>
<li>Maintain normal interior humidity levels. MIKASA flooring requires a relative humidity range of 30-60%. Relative humidity should never fall below 35% or exceed 55%.</li>
</ul>
<ul>
<li>Place area rugs in high or concentrated traffic areas to make long-term maintenance easier and less expensive.</li>
</ul>
<ul>
<li>Maintain normal temperature range 18&deg;C - 24&deg;C.</li>
</ul>
<p>Failure to ensure a maintain a dry sub-floor and/or crawl-space or failure to regulate environmental RH or temperature as required can lead to excessive cupping, splitting, checking and gapping. Such occurrences will not be covered by any MIKASA warranty.</p>
        </div>


        <div class="section">
            <h2>Preventive Measures</h2>
<ol>
<li>Place proper walk-off mats in doorways to keep out dirt and grit.</li>
</ol>
<ol start="2">
<li>Install floor protector on tables and chairs used on hardwood floors.</li>
</ol>
<ol start="3">
<li>Avoid excess moisture from tracked-in water and leaks. Never wet mop a hardwood floor using a string mop and bucket.</li>
</ol>
<ol start="4">
<li>Do not slide heavy items across floor (fixtures, display racks, etc.).</li>
</ol>
<ol start="5">
<li>Use floor guards under all rolling furniture.</li>
</ol>
        </div>


<div class="section">

<h2>Daily Maintenance</h2>
<ol>
<li>Vacuum and clean walk-off mats daily to maximize their effectiveness.</li>
</ol>
<ol start="2">
<li>Dust mop floors daily to remove all dust, grit and other abrasive particles. Replace dust mop as needed.</li>
</ol>
<p>*DO NOT TREAT DUST MOP WITH ANY CHEMICALS.</p>
<ol start="3">
<li>Spot clean heavy traffic areas with a BONA Premium Microfiber Floor Mop and BONA Wood Floor Cleaner.</li>
</ol>
<ol start="4">
<li>Use BONA Wood Floor Cleaner to remove heel marks and spills.</li>
</ol>

</div>


<div class="section">

<h2>Deep Cleaning</h2>
<ol>
<li>Vacuum or dust mop floor to make sure floor is free of all dust, grit and abrasive particles prior to buffing floor. This will prevent any grit or dust that could get into the buffing pad and leave scratches.</li>
</ol>
<p>Option #1: With a 175 buffer and a white polishing pad lightly mist (8&rsquo; x 8&rsquo; area) with BONA Deep Clean Solution.</p>
<p>Option #2: With an auto-scrubber use BONA Deep Clean Solution and make sure the water setting is on low.</p>
<p>Note: Option 2 applicable when floors have been re-coated immediately after installation only.</p>
<ol start="2">
<li>Remove dirt&nbsp;residue immediately with a slightly water-dampened BONA Premium Microfiber Floor Mop. Move on to the next section. Periodically replace the buffing pad and BONA Dusting Pad as they become soiled.</li>
</ol>
<ol start="3">
<li>If it is necessary to move fixtures during the deep cleaning, make sure fixtures are not dragged across the floor. Please lift and place them back.</li>
</ol>
<ol start="4">
<li>Due to traffic and active usage of the floor, there will be minor scratches and the gloss tends to go down. Bona Hardwood Floor Polish offers a protective formula that renews floors by filling in micro-scratches and scuffs, shielding against future wear and traffic, and adding a durable gloss shine. Use every 2-6 months, depending on foot traffic, to keep floors revitalized and looking their best.</li>
</ol>

</div>




<div class="section">

<h2>Recoating Procedures</h2>

<p>&nbsp;The perfect time to recoat your floor is at the first sign of finish wear before the finish wears through to the bare wood. Recoating your floor before wear-through will save you from a complete sand and finish.</p>
<ul>
<li>The time frame for recoats is as follows:</li>
</ul>
<p>Street store: 8 to 18 months</p>
<p>Inside a mall store: 1 to 3 years</p>
<p>MIKASA floors can be refinished without removing the factory finish. As a floor ages, signs of normal wear and tear should be expected. This is natural,it happens to all wood floors! To restore the lustre&nbsp;and extend the wear layer of the MIKASA wood floor recoat with a water based urethane coating. Recoating your floor without removing the factory finish will not void the Wear Through Guarantee. Recoating should be done when necessary. Don&rsquo;t wait until the finish has worn down. Call your professional flooring contractor for recommendations as soon as you see a wear pattern developing.</p>
<p>Note: To achieve a uniform look coat the worn traffic areas first followed with a coat over the entire floor.</p>
<p>Recommended Finishes: BONA SOLUTION</p>
<p>NOTE: Not Applicable to Natural Oiled Floors</p>
<p style="color: red;">All disputes pertaining to the warranty terms and conditions shall have jurisdiction at New Delhi Courts only.</p>

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
