<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="order-status-bg">
                            <div class="card-header order-status-flex">
                                <strong>Invoice Number - 000002057 | Date - 18 Jun 2025</strong>
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    Order Status:
                                    <button type="button" class="btn btn-success">Success</button>
                                    <button type="button" class="btn btn-danger">Pending</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="product_type"
                                                        class="form-label custom-form-label">Product Type</label>
                                                    <select class="form-select" id="product_type" onchange="toggleDiv()">
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
                                                    <label for="qty_purchased" class="form-label custom-form-label">Quantity
                                                        Purchased</label>
                                                    <input class="form-control" id="qty_purchased" type="text"
                                                        placeholder="Enter Qty Purchased">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="application" class="form-label custom-form-label">Application
                                    Type</label>

                                <select class="form-select" id="application" name="application">
                                    <option selected>Select Product Type</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Residential">Residential</option>

                                </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="place_of_purchase"
                                                        class="form-label custom-form-label">Place of Purchase</label>
                                                    <input class="form-control" id="place_of_purchase" type="text"
                                                        placeholder="Enter Place of Purchase">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="invoice_number"
                                                        class="form-label custom-form-label">Invoice Number</label>
                                                    <input class="form-control" id="invoice_number" type="text"
                                                        placeholder="Enter Invoice Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="upload_invoice"
                                                        class="form-label custom-form-label">Upload Invoice</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-lg-4" id="myDivMikasaDoors">
                                                <div class="form-group">
                                                    <label for="upload_handover_certificate"
                                                        class="form-label custom-form-label">Upload Handover
                                                        Certificate</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <button class="custom-btn-blk">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="order-status-bg">
                            <div class="card-header order-status-flex">
                                <strong>Invoice Number - 000002056 | Date - 18 Jun 2025</strong>
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    Order Status:
                                    <button type="button" class="btn btn-success">Success</button>
                                    <button type="button" class="btn btn-danger">Pending</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="product_tpye"
                                                        class="form-label custom-form-label">Product Tpye</label>
                                                    <select class="form-select" id="mySelect"
                                                        onchange="toggleDiv()">
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
                                                    <label for="qty_purchased"
                                                        class="form-label custom-form-label">Quantity Purchased</label>
                                                    <input class="form-control" id="qty_purchased" type="text"
                                                        placeholder="Enter Qty Purchased">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="application" class="form-label custom-form-label">Application
                                    Type</label>

                                <select class="form-select" id="application" name="application">
                                    <option selected>Select Product Type</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Residential">Residential</option>

                                </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="place_of_purchase"
                                                        class="form-label custom-form-label">Place of Purchase</label>
                                                    <input class="form-control" id="place_of_purchase" type="text"
                                                        placeholder="Enter Place of Purchase">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="invoice_number"
                                                        class="form-label custom-form-label">Invoice Number</label>
                                                    <input class="form-control" id="invoice_number" type="text"
                                                        placeholder="Enter Invoice Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="upload_invoice"
                                                        class="form-label custom-form-label">Upload Invoice</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-lg-4" id="myDivMikasaDoors">
                                                <div class="form-group">
                                                    <label for="upload_handover_certificate"
                                                        class="form-label custom-form-label">Upload Handover
                                                        Certificate</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <button class="custom-btn-blk">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-userdashboard-layout>
