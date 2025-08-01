<form id="editWarrantyForm" data-warranty-id="{{ $warranty->id }}" enctype="multipart/form-data">
    @csrf

    <h5 class="mb-3">Dealer Details</h5>
    <table class="table table-bordered table-striped mb-3">
        <thead>
            <tr>
                <th>Dealer Name</th>
                <th>Dealer City</th>
                <th>Dealer State</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $warranty->dealer_name }}</td>
                <td>{{ $warranty->dealer_city }}</td>
                <td>{{ $warranty->dealer_state }}</td>
            </tr>
        </tbody>
    </table>
    <div class="row">

        <div class="col-md-6 mb-6">
            <label for="invoice_number">Invoice Number</label>
            <input type="text" class="form-control" name="invoice_number" value="{{ $warranty->invoice_number }}">
        </div>

        <div class="col-md-6 mb-6">
            <label for="upload_invoice">Upload Invoice</label>
            <input type="file" class="form-control" name="upload_invoice">
            @if ($warranty->upload_invoice)
                <a href="{{ asset('storage/' . $warranty->upload_invoice) }}" target="_blank"
                    class="download-icon-red">View Existing</a>
            @endif
        </div>
    </div>

    <h5>Products</h5>
    <div id="editProducts">
        @foreach ($warranty->products as $index => $product)
            @if ($product->branch_admin_status == 'modify')
                <input type="hidden" name="product_id[]" value="{{ $product->id }}">

                <div class="border rounded p-3 mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Product Type {{ $product->product_status }}</label>
                            <select class="form-select" id="product_type" name="product_type[]">
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}"
                                        {{ $p->id == $product->product_type ? 'selected' : '' }}>{{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Quantity Purchased</label>
                            <input type="number" class="form-control" name="qty_purchased[]"
                                value="{{ $product->qty_purchased }}">
                        </div>
                        <div class="col-md-6 mt-2 application-wrapper">
                            <label>Application Type</label>
                            <select class="form-select" name="application[]">
                                <option value="Commercial"
                                    {{ $product->application_type == 'Commercial' ? 'selected' : '' }}>Commercial
                                </option>
                                <option value="Residential"
                                    {{ $product->application_type == 'Residential' ? 'selected' : '' }}>Residential
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2 handover-wrapper">
                            <label>Upload Handover Certificate</label>
                            <input type="file" class="form-control" name="handover_certificate[]">
                            @if ($product->handover_certificate)
                                <a href="{{ asset('uploads/handover_certificates/' . $product->handover_certificate) }}"
                                    target="_blank" class="download-icon-red">View Existing</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Save Changes</button>
    </div>
</form>



<script>
    // Handle product_type change for dynamically loaded edit form
    $(document).on('change', '#editWarrantyModel select[name="product_type[]"]', function() {
        let selectedValue = $(this).val();
        let $row = $(this).closest('.border'); // Each product is wrapped in .border

        // Show/Hide Upload Handover Certificate div
        if (selectedValue == 2) {
            $row.find('.handover-wrapper').show();
        } else {
            $row.find('.handover-wrapper').hide();
        }

        // Show/Hide Application Type div
        if (selectedValue == 4 || selectedValue == 6) {
            $row.find('.application-wrapper').hide();
        } else {
            $row.find('.application-wrapper').show();
        }
    });

    // Trigger show/hide logic on initial load for all product rows
    function applyProductTypeConditions() {
        $('#editWarrantyModel select[name="product_type[]"]').each(function() {
            let selectedValue = $(this).val();
            let $row = $(this).closest('.border');

            // Show/Hide Upload Handover Certificate div
            if (selectedValue == 2) {
                $row.find('.handover-wrapper').show();
            } else {
                $row.find('.handover-wrapper').hide();
            }

            // Show/Hide Application Type div
            if (selectedValue == 4 || selectedValue == 6) {
                $row.find('.application-wrapper').hide();
            } else {
                $row.find('.application-wrapper').show();
            }
        });
    }




    // Handle edit warranty form submission
    $(document).on("submit", "#editWarrantyForm", function(e) {
        e.preventDefault();
        let warrantyId = $(this).data("warranty-id");
        let formData = new FormData(this);

        $.ajax({
            url: "/user/warranty/update/" + warrantyId,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                $("#editWarrantyModel").modal("hide");
                location.reload(); // or update table dynamically
            },
            error: function(xhr) {

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        let fieldName = field.replace(/\.\d+/g,
                            ''); // remove index for arrays
                        $(`#error-${fieldName}`).text(messages[0]);
                    });
                } else {
                    alert('Failed to update warranty');
                }

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
