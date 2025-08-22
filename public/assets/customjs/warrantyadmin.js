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
    flatpickr("#datepickercustom", {
        dateFormat: "Y-m-d",
        // minDate: "2022-07-30",
        // defaultDate: new Date($("input[name='created_at']").val()),
        disable: [
            function (date) {
                return date > new Date($("input[name='created_at']").val());
            },
        ],
    });

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
                                product.branch_admin_status === "pending"
                                    ? "bg-warning"
                                    : product.branch_admin_status === "rejected"
                                    ? "bg-danger"
                                    : product.branch_admin_status === "approved"
                                    ? "bg-success"
                                    : "bg-secondary"
                            } text-white">${
                    product.branch_admin_status?.toUpperCase() || "N/A"
                }</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill ${
                                product.country_admin_status === "pending"
                                    ? "bg-warning"
                                    : product.country_admin_status ===
                                      "rejected"
                                    ? "bg-danger"
                                    : product.country_admin_status ===
                                      "approved"
                                    ? "bg-success"
                                    : "bg-secondary"
                            } text-white">${
                    product.country_admin_status?.toUpperCase() || "N/A"
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

function getVariantsAsJson() {
    var variants = [];

    // Check if there are any rows
    var $rows = $("#product-variants-table tbody tr");
    if ($rows.length === 0) {
        return JSON.stringify(variants); // return empty array
    }

    $rows.each(function () {
        var thickness = $(this)
            .find('input[name="product_thickness[]"]')
            .val()
            .trim();
        var quantity = $(this).find('input[name="quantity[]"]').val().trim();

        // Only include rows with both values
        if (thickness !== "" && quantity !== "") {
            variants.push({
                thickness: thickness,
                quantity: quantity,
            });
        }
    });

    return JSON.stringify(variants);
}

$(document).ready(function () {
    $(".save-product-btn").on("click", function () {
        const button = $(this);
        const row = button.closest(".card-body");
        const productId = button.data("id");

        // Collect JSON table data
        let productsData = [];
        $("#productTable tbody tr").each(function () {
            let product = $(this).find(".product_name_selectply").val();
            let qty = $(this).find(".product_qty").val();
            let warranty = $(this).find(".warranty_years").val();

            if (product) {
                productsData.push({
                    product_name: product,
                    quantity: qty,
                    warranty_years: warranty,
                });
            }
        });

        let productsDataFloor = [];

        $("#productTableFloor tbody tr").each(function () {
            let product = $(this).find(".product_name_selectmfloor").val();
            let qty = $(this).find(".product_qty").val();
            let warranty = $(this).find(".warranty_years").val();

            if (product) {
                productsDataFloor.push({
                    product_name: product,
                    quantity: qty,
                    warranty_years: warranty,
                });
            }
        });

        var ThicknessJson = getVariantsAsJson();

        // console.log(ThicknessJson);

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
                products_json: JSON.stringify(productsData),
                products_jsonFloor: JSON.stringify(productsDataFloor),
                product_name:
                    row.find(".product_name_select").val() ||
                    row.find(".product_name_input").val(),
                warranty_years: row.find(".warranty_hidden").val(),
                branch_name: row.find(".branch_name").val(),
                date_of_issuance: row.find(".date_of_issuance").val(),
                invoice_date: row.find(".invoice_date").val(),
                execution_agency: row.find(".execution_agency").val(),
                handover_certificate_date: row
                    .find(".handover_certificate_date")
                    .val(),
                product_code: row.find(".product_code").val(),
                surface_treatment_type: row
                    .find(".surface_treatment_type")
                    .val(),
                product_thickness: ThicknessJson,
                project_location: row.find(".project_location").val(),
            },
            success: function (response) {
                row.closest("tr")
                    .find(".save-message")
                    .removeClass("d-none")
                    .text("Updated!")
                    .fadeIn()
                    .delay(3000)
                    .fadeOut();

                // Close the collapseRow after save
                row.closest(".collapse").collapse("hide");
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
                    errorDiv
                        .removeClass("d-none")
                        .html("Something went wrong. Please try again.");
                }
            },
        });
    });

    $(document).on("change", ".product_name_select", function () {
        var warranty = $(this).find(":selected").data("warranty") || "";
        $(this).closest(".row").find(".warranty_hidden").val(warranty);
    });

    $(document).on("change", ".branch_admin_status", function () {
        var status = $(this).val();
        var badge = $(this).closest("tr").find(".status-badge");

        // Remove existing bg-* classes
        badge.removeClass("bg-warning bg-info bg-success");

        // Update badge text & color
        if (status === "pending") {
            badge.addClass("bg-warning").text("Status: Pending");
        } else if (status === "modify") {
            badge.addClass("bg-info").text("Status: Modify");
        } else if (status === "approved") {
            badge.addClass("bg-success").text("Status: Approved");
        }
    });
});

$(document).ready(function () {
    // Populate select options
    function populateSelect($select) {
        $select.empty().append('<option value="">Select Product Type</option>');
        productTypes.forEach(function (type) {
            $select.append(
                `<option value="${type.type}" data-warranty="${type.warranty}">
                    ${type.type}
                </option>`
            );
        });
    }

    // Initialize first row select
    // populateSelect($("#productTable tbody tr:first .product_name_selectply"));

    // Auto-fill warranty
    $(document).on("change", ".product_name_selectply", function () {
        let warranty = $(this).find(":selected").data("warranty") || "";
        $(this).closest("tr").find(".warranty_years").val(warranty);
    });

    // Add new row
    $("#addRow").click(function () {
        let newRow = `<tr>
            <td><select class="form-control product_name_selectply"></select></td>
            <td><input type="number" class="form-control product_qty" value="1" min="1"></td>
            <td><input type="text" class="form-control warranty_years" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>`;

        let $row = $(newRow);
        populateSelect($row.find(".product_name_selectply"));
        $("#productTable tbody").append($row);
    });

    // Remove row
    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
    });

    // Get JSON
    $("#getJson").click(function () {
        let data = [];
        $("#productTable tbody tr").each(function () {
            let product = $(this).find(".product_name_selectply").val();
            let qty = $(this).find(".product_qty").val();
            let warranty = $(this).find(".warranty_years").val();

            if (product) {
                data.push({
                    product_name: product,
                    quantity: qty,
                    warranty_years: warranty,
                });
            }
        });

        $("#output").text(JSON.stringify(data, null, 2));
    });
});

$(document).ready(function () {
    // Populate select options
    function populateSelectFloor($select) {
        $select.empty().append('<option value="">Select Product Type</option>');
        productTypesFloor.forEach(function (type) {
            $select.append(
                `<option value="${type.type}" data-warranty="${type.warranty}">
                    ${type.type}
                </option>`
            );
        });
    }

    // Initialize first row select
    // populateSelectFloor(
    //     $("#productTableFloor tbody tr:first .product_name_selectmfloor")
    // );

    // Auto-fill warranty
    $(document).on("change", ".product_name_selectmfloor", function () {
        let warranty = $(this).find(":selected").data("warranty") || "";
        $(this).closest("tr").find(".warranty_years").val(warranty);
    });

    // Add new row
    $("#addRowFloor").click(function () {
        let newRow = `<tr>
            <td><select class="form-control product_name_selectmfloor"></select></td>
            <td><input type="number" class="form-control product_qty" value="1" min="1"></td>
            <td><input type="text" class="form-control warranty_years" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>`;

        let $row = $(newRow);
        populateSelectFloor($row.find(".product_name_selectmfloor"));
        $("#productTableFloor tbody").append($row);
    });

    // Remove row
    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
    });

    // Get JSON
    // $("#getJsonFloor").click(function () {
    //     let data = [];
    //     $("#productTableFloor tbody tr").each(function () {
    //         let product = $(this).find(".product_name_selectmfloor").val();
    //         let qty = $(this).find(".product_qty").val();
    //         let warranty = $(this).find(".warranty_years").val();

    //         if (product) {
    //             data.push({
    //                 product_name: product,
    //                 quantity: qty,
    //                 warranty_years: warranty,
    //             });
    //         }
    //     });

    //     $("#outputFloor").text(JSON.stringify(data, null, 2));
    // });
});

$(function () {
    // Add new row
    $(document).on("click", ".add-variant", function (e) {
        e.preventDefault();

        var $currentRow = $(this).closest("tr");

        // Optional: prevent adding blank rows
        var thickness = $currentRow
            .find('input[name="product_thickness[]"]')
            .val()
            .trim();
        var quantity = $currentRow
            .find('input[name="quantity[]"]')
            .val()
            .trim();
        if (thickness === "" || quantity === "") {
            alert(
                "Please fill both Thickness and Quantity before adding a new row."
            );
            return false;
        }

        // Clone the row
        var $newRow = $currentRow.clone();

        // Clear input values
        $newRow.find("input").val("");

        // Change Add button to Remove button
        $newRow
            .find("button")
            .removeClass("btn-success add-variant")
            .addClass("btn-danger remove-variant")
            .html('<i class="fa fa-trash"></i>');

        // Append new row
        $("#product-variants-table tbody").append($newRow);
    });

    // Remove row
    $(document).on("click", ".remove-variant", function (e) {
        e.preventDefault();
        $(this).closest("tr").remove();
    });
});
