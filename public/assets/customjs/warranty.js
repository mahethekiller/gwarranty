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

$(document).ready(function () {
    // Add new row
    $('#addNewRow').on('click', function () {
        let $clone = $('#tableBody tbody tr:first').clone();
        $clone.find('input, select').val(''); // Clear input values
        $clone.find('#handover_certificate_preview').empty(); // Clear file preview
        $clone.find('.text-danger strong').text(''); // Clear error messages
        $('#tableBody tbody').append($clone);
        $clone.find('#product_type').trigger('change'); // Apply visibility logic
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        if ($('#tableBody tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('At least one row is required.');
        }
    });

    // Show/Hide fields based on Product Type
    $(document).on('change', '#product_type', function () {
        let selectedValue = $(this).val();
        let $row = $(this).closest('tr');

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

    // Trigger change for default row
    $('#tableBody tbody tr').each(function () {
        $(this).find('#product_type').trigger('change');
    });
});

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

    $("#spinner").show();

    let formData = new FormData(this);

    // Clear all previous errors
    $("[id^=error-]").text("");

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
            $("#spinner").hide();
            alert(response.message);
            location.reload();
            $("#warrantyForm")[0].reset();
            $("#tableBody tbody").html($("#tableBody tbody tr:first").clone()); // Reset rows
        },
        error: function (xhr) {
            $("#spinner").hide();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    let fieldName = field.replace(/\.\d+/g, ''); // remove index for arrays
                    $(`#error-${fieldName}`).text(messages[0]);
                });
            } else {
                alert('An unexpected error occurred.');
            }
        }
    });
});


$("#qty_purchased").on("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, "");
});

$("#place_of_purchase").on("input", function (e) {
    this.value = this.value.replace(/[^a-zA-Z]/g, "");
});

// Use event delegation for dynamically added file inputs
$(document).on("change", 'input[name="handover_certificate[]"]', function () {
    const file = this.files[0];
    const $row = $(this).closest("tr"); // Target the current row
    const previewContainer = $row.find("#handover_certificate_preview")[0];

    if (file) {
        const fileURL = URL.createObjectURL(file);

        // Create a preview link
        const previewLink = document.createElement("a");
        previewLink.href = fileURL;
        previewLink.target = "_blank"; // Open in new tab
        previewLink.innerHTML = "Preview";
        previewLink.classList.add("btn", "btn-primary", "mt-2", "btn-sm");

        // Clear previous preview and append the new one
        previewContainer.innerHTML = "";
        previewContainer.appendChild(previewLink);
    } else {
        // Clear preview if no file is selected
        previewContainer.innerHTML = "";
    }
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

// $("#product_type").on("change", function () {
//     const value = $(this).val();
//     const div = document.getElementById("myDivMikasaDoors");
//     if (value === "4" || value === "6") {
//         //"Greenlam Clads"  "Greenlam Sturdo"
//         $("#application").prop("disabled", true).closest(".form-group").hide();
//     } else {
//         $("#application").prop("disabled", false).closest(".form-group").show();
//     }

//     if (value === "2") {
//         div.style.display = "block";
//     } else {
//         div.style.display = "none";
//     }
// });

// Handle edit warranty modal population
$(document).on("click", '[data-bs-target="#editWarrantyModel"]', function (e) {
    e.preventDefault();
    var warrantyId = $(this).data("id"); // Retrieve ID from the clicked element's data-id attribute
    $("#editWarrantyModel form").data("warranty-id", warrantyId);

    // Fetch warranty data from server
    $.ajax({
        url: "/user/warranty/edit/" + warrantyId,
        type: "GET",
        success: function (response) {
            // debugger

            if (response.message) {
                alert(response.message);
            } else {
                $("#editWarrantyModelBody").html(response);
            }
        },
        error: function (xhr) {
            alert("Error fetching warranty data");
            console.log(xhr.responseText);
        },
    });
});



$(document).ready(function () {
    // Initialize DataTable
    // $('#warrantyTable').DataTable();

    // Open modal with product details
    $(document).on('click', '.view-products-btn', function () {
        let products = $(this).data('products');
        let title = $(this).data('title');

        // Set modal title
        $('#productsModalLabel').text(title);

        // Build table rows
        let rows = '';
        if (products.length > 0) {
            products.forEach(function (product) {
                rows += `
                    <tr>
                        <td>${product.product?.name || 'N/A'}</td>
                        <td>${product.qty_purchased || 'N/A'}</td>
                        <td>${product.application_type || 'N/A'}</td>
                        <td>
                            ${product.handover_certificate
                                ? `<a href="/storage/${product.handover_certificate}" target="_blank" class="download-icon-red">
                                     <i class="fa fa-download"></i>&nbsp;View
                                   </a>`
                                : 'N/A'}
                        </td>
                    </tr>
                `;
            });
        } else {
            rows = `<tr><td colspan="4" class="text-center">No Products Found</td></tr>`;
        }

        // Insert rows into modal
        $('#productsModalBody').html(rows);

        // Show modal
        $('#productsModal').modal('show');
    });
});



$(document).ready(function () {
    const stateSelect = $('#dealer_state');
    const citySelect = $('#dealer_city');

    stateSelect.on('change', function () {
        const selectedState = $(this).val();

        // Clear city dropdown
        citySelect.html('<option value="">Select City</option>');

        if (selectedState) {
            $.get(`/get-cities/${encodeURIComponent(selectedState)}`)
                .then(cities => {
                    cities.forEach(city => {
                        const option = $('<option>').val(city).text(city);
                        citySelect.append(option);
                    });
                });
        }
    });
});

