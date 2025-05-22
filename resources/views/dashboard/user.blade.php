<x-userdashboard-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}




    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <label for="builder_contractor" class="form-label custom-form-label">Bought it for
                    yourself (Builder/Contractor?)</label>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv1(true)" class="form-check-input" type="radio" name="radio"
                                id="radio-1" required>
                            <label class="form-check-label" for="radio-1"> Yes </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input onclick="toggleDiv2(true)" class="form-check-input" type="radio" name="radio"
                                id="radio-2" required>
                            <label class="form-check-label" for="radio-2"> No </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-12" id="targetDiv1" style="display: none;">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="product_tpye" class="form-label custom-form-label">Product
                                    Tpye</label>
                                <select class="form-select" id="mySelect" onchange="toggleDiv()">
                                    <option selected>Select Product Type</option>
                                    <option value="1">Mikasa Floors</option>
                                    <option value="mikasa_doors">Mikasa Doors</option>
                                    <option value="3">Mikasa Ply</option>
                                    <option value="4">Greenlam Clads</option>
                                    <option value="5">NewMikaFx</option>
                                    <option value="6">Greenlam Sturdo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="qty_purchased" class="form-label custom-form-label">Qty
                                    Purchased</label>
                                <input class="form-control" id="qty_purchased" type="text"
                                    placeholder="Enter Qty Purchased">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="application_commercial_residential"
                                    class="form-label custom-form-label">Application
                                    (Commercial/Residential)</label>
                                <input class="form-control" id="application_commercial_Residential" type="text"
                                    placeholder="Enter Application (Commercial/Residential)">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="place_of_purchase" class="form-label custom-form-label">Place
                                    of Purchase</label>
                                <input class="form-control" id="place_of_purchase" type="text"
                                    placeholder="Enter Place of Purchase">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="invoice_number" class="form-label custom-form-label">Invoice
                                    Number</label>
                                <input class="form-control" id="invoice_number" type="text"
                                    placeholder="Enter Invoice Number">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="upload_invoice" class="form-label custom-form-label">Upload
                                    Invoice</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                        </div>
                        <div class="col-lg-4" id="myDivMikasaDoors">
                            <div class="form-group">
                                <label for="upload_handover_certificate" class="form-label custom-form-label">Upload
                                    Handover
                                    Certificate</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button class="custom-btn-blk">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-xl-12" id="targetDiv2" style="display: none;">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <h6>“Please contact the builder/contractor for warranty”​</h6>
                </div>
            </div>
        </div>
    </div>
</x-userdashboard-layout>
