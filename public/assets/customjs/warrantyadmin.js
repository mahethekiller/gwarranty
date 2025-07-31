// Handle edit warranty modal population
$(document).on("click", '[data-bs-target="#editWarrantyModel"]', function (e) {
    e.preventDefault();
    var warrantyId = $(this).data("id"); // Retrieve ID from the clicked element's data-id attribute

    // Fetch warranty data from server
    $.ajax({
        url: "/admin/warranty/edit/" + warrantyId,
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
    $("#warrantyTable").DataTable({
        order: [[0, "asc"]],
    });

    // Handle View Products button click
    $(document).on("click", ".view-products-btn", function () {
        let products = $(this).data("products");
        let title = $(this).data("title");

        // Set modal title
        $("#productsModalLabel").text(title);

        // Build table rows
        let rows = "";
        if (products.length > 0) {
            products.forEach(function (product) {
                rows += `
                    <tr>
                        <td>${product.product?.name || "N/A"}</td>
                        <td>${product.qty_purchased || "N/A"}</td>
                        <td>${product.application_type || "N/A"}</td>
                        <td>
                            ${
                                product.handover_certificate
                                    ? `<a href="/storage/${product.handover_certificate}" target="_blank" class="download-icon-red">
                                     <i class="fa fa-download"></i>&nbsp;View
                                   </a>`
                                    : "N/A"
                            }
                        </td>
                        <td>${product.remarks || "N/A"}</td>
                        <td>
                            <span class="badge rounded-pill ${
                                product.product_status === "pending"
                                    ? "bg-warning"
                                    : product.product_status === "modify"
                                    ? "bg-danger"
                                    : product.product_status === "approved"
                                    ? "bg-success"
                                    : "bg-secondary"
                            } text-white">${
                    product.product_status?.toUpperCase() || "N/A"
                }</span>
                        </td>
                    </tr>
                `;
            });
        } else {
            rows = `<tr><td colspan="4" class="text-center">No Products Found</td></tr>`;
        }

        // Insert rows into modal
        $("#productsModalBody").html(rows);

        // Show modal
        $("#productsModal").modal("show");
    });
});

$(document).ready(function () {
    $(".save-product-btn").on("click", function () {
    const button = $(this);
    const row = button.closest(".card-body");
    const productId = button.data("id");

    $.ajax({
        url: adminurl + "/warranty/update/product/" + productId,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            _method: "PUT",
            total_quantity: row.find(".total_quantity").val(),
            branch_admin_status: row.find(".branch_admin_status").val(),
            country_admin_status: row.find(".country_admin_status").val(),
            product_remarks: row.find(".product_remarks").val(),
            product_name: row.find(".product_name_select").val() || row.find(".product_name_input").val(),
            warranty_years: row.find(".warranty_hidden").val(),
            branch_name: row.find(".branch_name").val(),
            date_of_issuance: row.find(".date_of_issuance").val(),
            invoice_date: row.find(".invoice_date").val(),
            execution_agency: row.find(".execution_agency").val(),
            handover_certificate_date: row.find(".handover_certificate_date").val(),
            product_code: row.find(".product_code").val(),
            surface_treatment_type: row.find(".surface_treatment_type").val(),
            product_thickness: row.find(".product_thickness").val(),
            project_location: row.find(".project_location").val(),
        },
        success: function (response) {
            row.find(".save-message").removeClass("d-none").text("Saved!").fadeIn().delay(2000).fadeOut();
        },
        error: function (xhr) {
            const errorDiv = row.find(".error-message");
            if (xhr.status === 422) {
                let errorHtml = '<ul class="mb-0">';
                $.each(xhr.responseJSON.errors, function (field, messages) {
                    errorHtml += `<li>${messages[0]}</li>`;
                });
                errorHtml += "</ul>";
                errorDiv.removeClass("d-none").html(errorHtml);
            } else {
                errorDiv.removeClass("d-none").html("Something went wrong. Please try again.");
            }
        }
    });
});


    $(document).on("change", ".product_name_select", function () {
        var warranty = $(this).find(":selected").data("warranty") || "";
        $(this).closest(".row").find(".warranty_hidden").val(warranty);
    });
});
