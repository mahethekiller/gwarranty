<form action="" id="editWarrantyForm">
    @csrf

    <input type="hidden" name="warranty_id" id="warranty_id" value="{{ $warranty->id }}" />

    <div class="form-group row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="product_type" class="form-label custom-form-label">Product Type</label>
                <select class="form-select" id="product_type" name="product_type" >
                    <option value="" {{ $warranty->product_type == null ? 'selected' : '' }}>Select Product Type
                    </option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $warranty->product_type == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="error-product_type" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="qty_purchased" class="form-label custom-form-label">Qty</label>
                <input class="form-control" id="qty_purchased" name="qty_purchased" type="text"
                    placeholder="Enter Qty Purchased" value="{{ $warranty->qty_purchased }}">
                <span class="text-danger" id="error-qty_purchased" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6" id="applicationDiv"
            style="display: {{ $warranty->product_type != 'Greenlam Clads' && $warranty->product_type != 'Greenlam Sturdo' ? 'block' : 'none' }}">
            <div class="form-group">
                <label for="application" class="form-label custom-form-label">Application Type</label>
                <select class="form-select" id="application" name="application">
                    <option value="" {{ $warranty->application == null ? 'selected' : '' }}>Select Application
                        Type</option>
                    <option value="Commercial" {{ $warranty->application == 'Commercial' ? 'selected' : '' }}>
                        Commercial</option>
                    <option value="Residential" {{ $warranty->application == 'Residential' ? 'selected' : '' }}>
                        Residential</option>
                </select>
                <span class="text-danger" id="error-application" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="place_of_purchase" class="form-label custom-form-label">Place of Purchase</label>
                <input class="form-control" id="place_of_purchase" name="place_of_purchase" type="text"
                    placeholder="Enter Place of Purchase" value="{{ $warranty->place_of_purchase }}">
                <span class="text-danger" id="error-place_of_purchase" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group position-relative">
                <label for="invoice_number" class="form-label custom-form-label">Invoice Number</label>
                <input class="form-control" id="invoice_number" name="invoice_number" type="text"
                    placeholder="Enter Invoice Number" value="{{ $warranty->invoice_number }}">
                <span class="text-danger" id="error-invoice_number" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group position-relative">
                <label for="upload_invoice" class="form-label custom-form-label">Upload Invoice</label>
                <input class="form-control" type="file" id="upload_invoice" name="upload_invoice">
                <div id="invoice_preview" class="upload_invoice_preview">

                </div>
                <div id="invoice_preview_old" >
                    @if ($warranty->invoice_path != null)
                        <a href="/storage/{{ $warranty->invoice_path }}" target="_blank"
                            class="btn btn-primary btn-sm mt-2">View Existing Invoice</a>
                    @endif
                </div>
                <span class="text-danger" id="error-upload_invoice" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-6" id="myDivMikasaDoors"
            style="display: {{ $warranty->product_type == 2 ? 'block' : 'none' }}">
            <div class="form-group position-relative">
                <label for="handover_certificate" class="form-label custom-form-label">Upload Handover
                    Certificate</label>
                <input class="form-control" type="file" id="handover_certificate" name="handover_certificate">
                <div id="handover_certificate_preview" class="upload_invoice_preview">

                </div>
                <div id="handover_certificate_preview_old">
                    @if ($warranty->handover_certificate_path != null)
                        <a href="/storage/{{ $warranty->handover_certificate_path }}" target="_blank"
                            class="btn btn-primary btn-sm mt-2">View Existing Invoice</a>
                    @endif
                </div>
                <span class="text-danger" id="error-handover_certificate" role="alert"></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <div class="form-group">
                <button class="custom-btn-blk">Submit</button>
            </div>
        </div>
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
    $('#editWarrantyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var warrantyId = $('#warranty_id').val();

        // Reset error fields
        let errorFields = ['#error-product_type', '#error-qty_purchased', '#error-application',
            '#error-place_of_purchase', '#error-invoice_number', '#error-upload_invoice',
            '#error-handover_certificate'
        ];
        errorFields.forEach(field => {
            $(field).text('');
        });

        $.ajax({
            url: '/user/warranty/update/' + warrantyId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Warranty updated successfully');
                $('#editWarrantyModel').modal('hide');
                location.reload(); // Reload to reflect changes
            },
            error: function(xhr) {
                // alert('Error updating warranty');
                // console.log(xhr.responseText);
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    console.log(errors[field][0]);

                    $(`#error-${field}`).text(errors[field][0]);
                }
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
