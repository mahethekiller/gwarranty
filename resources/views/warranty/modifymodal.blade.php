<form id="editWarrantyForm" data-warranty-id="{{ $warranty->id }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="dealer_name">Dealer Name</label>
            <input type="text" class="form-control" name="dealer_name" value="{{ $warranty->dealer_name }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="dealer_city">Dealer City</label>
            <input type="text" class="form-control" name="dealer_city" value="{{ $warranty->dealer_city }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="place_of_purchase">Place of Purchase</label>
            <input type="text" class="form-control" name="place_of_purchase" value="{{ $warranty->place_of_purchase }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="invoice_number">Invoice Number</label>
            <input type="text" class="form-control" name="invoice_number" value="{{ $warranty->invoice_number }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="upload_invoice">Upload Invoice</label>
            <input type="file" class="form-control" name="upload_invoice">
            @if ($warranty->upload_invoice)
                <a href="{{ asset('uploads/invoices/' . $warranty->upload_invoice) }}" target="_blank" class="btn btn-sm btn-secondary mt-2">View Existing</a>
            @endif
        </div>
    </div>

    <h5>Products</h5>
    <div id="editProducts">
        @foreach($warranty->products as $index => $product)
            <div class="border rounded p-3 mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <label>Product Type</label>
                        <select class="form-select" name="product_type[]">
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" {{ $p->id == $product->product_type ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Quantity Purchased</label>
                        <input type="number" class="form-control" name="qty_purchased[]" value="{{ $product->qty_purchased }}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Application Type</label>
                        <select class="form-select" name="application[]">
                            <option value="Commercial" {{ $product->application_type == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="Residential" {{ $product->application_type == 'Residential' ? 'selected' : '' }}>Residential</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Upload Handover Certificate</label>
                        <input type="file" class="form-control" name="handover_certificate[]">
                        @if ($product->handover_certificate)
                            <a href="{{ asset('uploads/handover_certificates/' . $product->handover_certificate) }}" target="_blank" class="btn btn-sm btn-secondary mt-2">View Existing</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Save Changes</button>
    </div>
</form>



<script>
    $("#product_type").on("change", function () {
    const value = $(this).val();
    const div = document.getElementById("myDivMikasaDoors");
    if (value === "4" || value === "6") {   //"Greenlam Clads"  "Greenlam Sturdo"
        $("#application").prop("disabled", true).closest(".form-group").hide();
    } else {
        $("#application").prop("disabled", false).closest(".form-group").show();
    }


    if (value === "2") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
});

    // Handle edit warranty form submission
    $(document).on("submit", "#editWarrantyForm", function (e) {
    e.preventDefault();
    let warrantyId = $(this).data("warranty-id");
    let formData = new FormData(this);

    $.ajax({
        url: "/user/warranty/update/" + warrantyId,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            alert(response.message);
            $("#editWarrantyModel").modal("hide");
            location.reload(); // or update table dynamically
        },
        error: function (xhr) {
            alert("Failed to update warranty");
            console.log(xhr.responseText);
        }
    });
});


    $("#handover_certificate").on("change", function() {
        const file = this.files[0];
        const fileURL = URL.createObjectURL(file);
        const previewLink = document.createElement("a");
        previewLink.href = fileURL;
        previewLink.download = file.name;
        previewLink.innerHTML = "Preview";
        previewLink.classList.add("btn", "btn-warning", "mt-2", "btn-sm");
        const previewContainer = document.getElementById("handover_certificate_preview");
        previewContainer.innerHTML = "";
        previewContainer.appendChild(previewLink);
    });
    $("#upload_invoice").on("change", function() {
        const file = this.files[0];
        const fileURL = URL.createObjectURL(file);
        const previewLink = document.createElement("a");
        previewLink.href = fileURL;
        previewLink.download = file.name;
        previewLink.innerHTML = "Preview";
        previewLink.classList.add("btn", "btn-warning", "mt-2", "btn-sm");
        const previewContainer = document.getElementById("invoice_preview");
        previewContainer.innerHTML = "";
        previewContainer.appendChild(previewLink);
    });
</script>
