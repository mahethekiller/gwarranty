function toggleDiv1(show) {
    document.getElementById("targetDiv2").style.display = "none";
    document.getElementById("targetDiv1").style.display = show
        ? "block"
        : "none";
}

function toggleDiv2(show) {
    document.getElementById("targetDiv1").style.display = "none";
    document.getElementById("targetDiv2").style.display = show
        ? "block"
        : "none";
}

// function toggleDiv() {
//     const select = document.getElementById("mySelect");
//     const div = document.getElementById("myDivMikasaDoors");
//     if (select.value === "Mikasa Doors") {
//         div.style.display = "block";
//     } else {
//         div.style.display = "none";
//     }
// }

$("#warrantyForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr("action"),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#errorMessages").addClass("d-none").html("");
        },
        success: function (response) {
            alert("Warranty registered successfully");
            $("#warrantyForm")[0].reset();
        },
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            for (let field in errors) {
                console.log(errors[field][0]);

                $(`#error-${field}`).text(errors[field][0]);
            }
        },
    });
});



$("#qty_purchased").on("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, "");
});

$("#place_of_purchase").on("input", function (e) {
    this.value = this.value.replace(/[^a-zA-Z]/g, "");
});


$("#handover_certificate").on("change", function () {
    const file = this.files[0];
    const fileURL = URL.createObjectURL(file);
    const previewLink = document.createElement("a");
    previewLink.href = fileURL;
    previewLink.download = file.name;
    previewLink.innerHTML = "Preview";
    previewLink.classList.add("btn", "btn-primary", "mt-2", "btn-sm");
    const previewContainer = document.getElementById("handover_certificate_preview");
    previewContainer.innerHTML = "";
    previewContainer.appendChild(previewLink);
});
$("#upload_invoice").on("change", function () {
    const file = this.files[0];
    const fileURL = URL.createObjectURL(file);
    const previewLink = document.createElement("a");
    previewLink.href = fileURL;
    previewLink.download = file.name;
    previewLink.innerHTML = "Preview";
    previewLink.classList.add("btn", "btn-primary", "mt-2", "btn-sm");
    const previewContainer = document.getElementById("upload_invoice_preview");
    previewContainer.innerHTML = "";
    previewContainer.appendChild(previewLink);
});



$("#product_type").on("change", function () {
    const value = $(this).val();
    const div = document.getElementById("myDivMikasaDoors");
    if (value === "Greenlam Clads" || value === "Greenlam Sturdo") {
        $("#application").prop("disabled", true).closest(".form-group").hide();
    } else {
        $("#application").prop("disabled", false).closest(".form-group").show();
    }


    if (value === "Mikasa Doors") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
});

// Handle edit warranty modal population
$(document).on('click', '[data-bs-target="#editWarrantyModel"]', function (e) {
    e.preventDefault();
    var warrantyId = $(this).data('id'); // Retrieve ID from the clicked element's data-id attribute
    $('#editWarrantyModel form').data('warranty-id', warrantyId);

    // Fetch warranty data from server
    $.ajax({
        url: '/user/warranty/edit/' + warrantyId,
        type: 'GET',
        success: function (response) {
            $('#editWarrantyModel #product_type').val(response.product_type);
            $('#editWarrantyModel #qty_purchased').val(response.qty_purchased);
            $('#editWarrantyModel #application').val(response.application).trigger('change');
            $('#editWarrantyModel #place_of_purchase').val(response.place_of_purchase);
            $('#editWarrantyModel #invoice_number').val(response.invoice_number);

            // Display links to existing files if they exist
            if (response.invoice_path) {
                $('#editWarrantyModel #invoice_preview').html(
                    '<a href="/storage/' + response.invoice_path + '" target="_blank" class="btn btn-primary btn-sm mt-2">View Existing Invoice</a>'
                );
            } else {
                $('#editWarrantyModel #invoice_preview').html('');
            }

            if (response.handover_certificate_path) {
                $('#editWarrantyModel #handover_certificate_preview').html(
                    '<a href="/storage/' + response.handover_certificate_path + '" target="_blank" class="btn btn-primary btn-sm mt-2">View Existing Handover Certificate</a>'
                );
            } else {
                $('#editWarrantyModel #handover_certificate_preview').html('');
            }
        },
        error: function (xhr) {
            alert('Error fetching warranty data');
            console.log(xhr.responseText);
        }
    });
});

// Handle edit warranty form submission
$('#editWarrantyModel form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var warrantyId = $(this).data('warranty-id');

        $.ajax({
            url: '/user/warranty/update/' + warrantyId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
        success: function (response) {
            alert('Warranty updated successfully');
            $('#editWarrantyModel').modal('hide');
            location.reload(); // Reload to reflect changes
        },
        error: function (xhr) {
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
