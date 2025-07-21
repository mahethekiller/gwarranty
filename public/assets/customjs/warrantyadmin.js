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
    $('#warrantyTable').DataTable(
        {
            "order": [[ 0, "asc" ]]
        }
    );

    // Handle View Products button click
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
                        <td>${product.remarks || 'N/A'}</td>
                        <td>
                            <span class="badge rounded-pill ${
                                product.product_status === 'pending' ?
                                'bg-warning' : product.product_status === 'modify' ?
                                'bg-danger' : product.product_status === 'approved' ?
                                'bg-success' : 'bg-secondary'} text-white">${product.product_status?.toUpperCase() || 'N/A'}</span>
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
