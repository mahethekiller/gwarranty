
// Toggle functions for Yes/No radio buttons
function toggleDiv1(show) {
    document.getElementById("targetDiv2").style.display = "none";
    document.getElementById("targetDiv1").style.display = show ? "block" : "none";
}

function toggleDiv2(show) {
    document.getElementById("targetDiv1").style.display = "none";
    document.getElementById("targetDiv2").style.display = show ? "block" : "none";
}

$(document).ready(function () {
    let productRowIndex = 0;

    // Hide Add Product button initially
    $('#addProductRow').hide();

    // Handle radio button clicks
    $('input[name="radio"]').on('change', function() {
        if ($(this).val() === '1') {
            toggleDiv1(true);
        } else if ($(this).val() === '0') {
            toggleDiv2(true);
        }
    });

    // Add new product row
    $('#addProductRow').on('click', function () {
        productRowIndex++;
        let newRow = $('#productsTableBody tr:first').clone();

        // Update all names and IDs
        newRow.attr('data-index', productRowIndex);
        newRow.find('select, input, textarea').each(function () {
            let name = $(this).attr('name');
            if (name) {
                name = name.replace('[0]', '[' + productRowIndex + ']');
                let id = name.replace(/[\[\]]/g, '_');
                $(this).attr('name', name).attr('id', id);
            }

            // Clear values and hide fields
            if ($(this).is('select')) {
                $(this).val('');
                $(this).find('option:first').prop('selected', true);
                if ($(this).hasClass('product-type')) {
                    $(this).closest('td').show();
                } else {
                    $(this).closest('td').hide();
                }
            } else if ($(this).is('input') || $(this).is('textarea')) {
                $(this).val('');
                $(this).removeAttr('required');
                $(this).prop('readonly', false);
                $(this).prop('disabled', false);
                if (!$(this).hasClass('product-type')) {
                    $(this).closest('td').hide();
                }
            }
        });

        // Clear file inputs and previews
        newRow.find('input[type="file"]').val('');
        newRow.find('.handover-preview').empty();

        // Clear variant dropdown
        newRow.find('.variant-select').empty().append('<option value="">Select Variant</option>');

        // Show remove button for new row
        newRow.find('.remove-product-row').show();

        // Hide all fields except product type initially
        newRow.find('td').slice(1, -1).hide();
        newRow.find('td:last').show(); // Show action column

        // Add to table
        $('#productsTableBody').append(newRow);
    });

    // Remove product row
    $(document).on('click', '.remove-product-row', function () {
        if ($('#productsTableBody tr').length > 1) {
            $(this).closest('tr').remove();
            // Update visibility of Add Product button
            updateAddProductButton();
        } else {
            alert('At least one product is required.');
        }
    });

    // Handle product type change
    $(document).on('change', '.product-type', function () {
        let row = $(this).closest('tr');
        let productTypeId = $(this).val();

        if (productTypeId) {
            // Show Add Product button if at least one product is selected
            if (!$('#addProductRow').is(':visible')) {
                $('#addProductRow').show();
                row.find('.remove-product-row').show();
            }

            // Get product type name
            let productTypeName = $(this).find('option:selected').text();

            // Update row fields based on product type
            updateRowFields(row, productTypeName);

            // Get variants for this product type
            getVariantsForProduct(row, productTypeId);

            // Auto-fill UoM based on product type
            autoFillUoM(row, productTypeName);
        } else {
            // Hide all fields if no product type selected
            resetRowFields(row);
            // Hide Add Product button if no product selected
            updateAddProductButton();
        }
    });

    // Handle variant select change
    $(document).on('change', '.variant-select', function () {
        let variantId = $(this).val();
        let variantInput = $(this).siblings('.variant-input');

        if (variantId) {
            variantInput.val('').hide();
        } else {
            // Show variant input if no variant selected from dropdown
            // (only for product types that need manual variant input)
            let productTypeName = $(this).closest('tr').find('.product-type option:selected').text();
            if (productTypeName === 'Mikasa Ply' || productTypeName === 'Mikasa Floors') {
                variantInput.show();
            }
        }
    });

    // File preview for handover certificate
    $(document).on('change', '.handover-input', function () {
        let file = this.files[0];
        let previewContainer = $(this).closest('td').find('.handover-preview');

        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showErrorMessage('File size must be less than 2MB');
                $(this).val('');
                previewContainer.empty();
                return;
            }

            // Validate file type
            let validExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            let fileExtension = file.name.split('.').pop().toLowerCase();

            if (!validExtensions.includes(fileExtension)) {
                showErrorMessage('Invalid file type. Allowed: jpg, png, pdf, doc, docx');
                $(this).val('');
                previewContainer.empty();
                return;
            }

            let fileURL = URL.createObjectURL(file);
            let previewLink = $('<a>', {
                href: fileURL,
                target: '_blank',
                text: 'Preview',
                class: 'btn btn-sm btn-primary mt-1'
            });

            previewContainer.empty().append(previewLink);
        } else {
            previewContainer.empty();
        }
    });

    // File preview for invoice
    $('#upload_invoice').on('change', function () {
        let file = this.files[0];
        let previewContainer = $('#upload_invoice_preview');

        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showErrorMessage('File size must be less than 2MB');
                $(this).val('');
                previewContainer.empty();
                return;
            }

            // Validate file type
            let validExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            let fileExtension = file.name.split('.').pop().toLowerCase();

            if (!validExtensions.includes(fileExtension)) {
                showErrorMessage('Invalid file type. Allowed: jpg, png, pdf, doc, docx');
                $(this).val('');
                previewContainer.empty();
                return;
            }

            let fileURL = URL.createObjectURL(file);
            let previewLink = $('<a>', {
                href: fileURL,
                target: '_blank',
                text: 'Preview Invoice',
                class: 'btn btn-sm btn-primary'
            });

            previewContainer.empty().append(previewLink);
        } else {
            previewContainer.empty();
        }
    });

    // State-City dropdown
    $('#dealer_state').on('change', function () {
        let selectedState = $(this).val();
        let citySelect = $('#dealer_city');

        citySelect.html('<option value="">Select City</option>');

        if (selectedState) {
            $.get('/get-cities/' + encodeURIComponent(selectedState))
                .done(function (cities) {
                    cities.forEach(function (city) {
                        citySelect.append('<option value="' + city + '">' + city + '</option>');
                    });
                })
                .fail(function () {
                    showErrorMessage('Failed to load cities. Please try again.');
                });
        }
    });

    // Form submission
    $('#warrantyFormNew').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Clear previous errors
        clearErrors();

        // Validate at least one product
        let productCount = $('.product-type').filter(function() {
            return $(this).val() !== '';
        }).length;

        if (productCount === 0) {
            showErrorMessage('Please add at least one product.');
            return;
        }

        // Validate required fields for each product
        let isValid = true;
        let errorMessages = [];

        $('.product-row').each(function(index) {
            let productTypeName = $(this).find('.product-type option:selected').text();
            if (productTypeName) {
                // Check required fields based on product type
                switch(productTypeName) {
                    case 'Mikasa Ply':
                        let variantSelectPly = $(this).find('.variant-select').val();
                        let variantInputPly = $(this).find('.variant-input').val();
                        if (!variantSelectPly && !variantInputPly) {
                            errorMessages.push(`Row ${index + 1}: Variant is required for Mikasa Ply`);
                            isValid = false;
                        }
                        if (!$(this).find('.quantity-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Quantity is required for Mikasa Ply`);
                            isValid = false;
                        }
                        break;
                    case 'Mikasa Floors':
                        let variantSelectFloors = $(this).find('.variant-select').val();
                        let variantInputFloors = $(this).find('.variant-input').val();
                        if (!variantSelectFloors && !variantInputFloors) {
                            errorMessages.push(`Row ${index + 1}: Variant is required for Mikasa Floors`);
                            isValid = false;
                        }
                        if (!$(this).find('.boxes-input').val()) {
                            errorMessages.push(`Row ${index + 1}: No. of Boxes is required for Mikasa Floors`);
                            isValid = false;
                        }
                        if (!$(this).find('.area-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Area is required for Mikasa Floors`);
                            isValid = false;
                        }
                        break;
                    case 'Mikasa Doors':
                        if (!$(this).find('.quantity-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Quantity is required for Mikasa Doors`);
                            isValid = false;
                        }
                        if (!$(this).find('.handover-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Handover Certificate is required for Mikasa Doors`);
                            isValid = false;
                        }
                        if (!$(this).find('.thickness-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Product Thickness is required for Mikasa Doors`);
                            isValid = false;
                        }
                        break;
                    case 'Greenlam Clads':
                        if (!$(this).find('.product-name-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Product Name/Design is required for Greenlam Clads`);
                            isValid = false;
                        }
                        if (!$(this).find('.quantity-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Quantity is required for Greenlam Clads`);
                            isValid = false;
                        }
                        break;
                    case 'MikasaFx':
                        if (!$(this).find('.product-name-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Product Name/Design is required for MikasaFx`);
                            isValid = false;
                        }
                        if (!$(this).find('.quantity-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Quantity is required for MikasaFx`);
                            isValid = false;
                        }
                        if (!$(this).find('.site-address-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Site Address is required for MikasaFx`);
                            isValid = false;
                        }
                        break;
                    case 'Greenlam Sturdo':
                        if (!$(this).find('.product-category-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Product Category is required for Greenlam Sturdo`);
                            isValid = false;
                        }
                        if (!$(this).find('.quantity-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Quantity is required for Greenlam Sturdo`);
                            isValid = false;
                        }
                        if (!$(this).find('.site-address-input').val()) {
                            errorMessages.push(`Row ${index + 1}: Site Address is required for Greenlam Sturdo`);
                            isValid = false;
                        }
                        break;
                }
            }
        });

        if (!isValid) {
            showErrorMessage('<ul>' + errorMessages.map(msg => `<li>${msg}</li>`).join('') + '</ul>');
            return;
        }

        // Show loading indicator
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // Submit the form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                submitBtn.prop('disabled', false).html(originalText);
                if (response.success) {
                    showSuccessMessage(response.message);
                    // Redirect or reload after 2 seconds
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    showErrorMessage(response.message);
                }
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).html(originalText);

                if (xhr.status === 422) {
                    // Laravel validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';

                    $.each(errors, function (field, messages) {
                        // Clean up field name for display
                        let fieldName = field.replace('products.', '').replace(/\.\d+\./, ' ');
                        fieldName = formatFieldName(fieldName);
                        errorHtml += '<li><strong>' + fieldName + ':</strong> ' + messages[0] + '</li>';
                    });

                    errorHtml += '</ul>';
                    showErrorMessage(errorHtml);

                } else if (xhr.status === 419) {
                    // CSRF token mismatch
                    showErrorMessage('Your session has expired. Please refresh the page and try again.');
                } else if (xhr.status === 500) {
                    // Server error
                    try {
                        let response = JSON.parse(xhr.responseText);
                        showErrorMessage(response.message || 'A server error occurred. Please try again.');
                    } catch (e) {
                        showErrorMessage('A server error occurred. Please try again.');
                    }
                } else {
                    // Other errors
                    try {
                        let response = JSON.parse(xhr.responseText);
                        showErrorMessage(response.message || 'An unexpected error occurred.');
                    } catch (e) {
                        showErrorMessage('An unexpected error occurred. Please try again.');
                    }
                }
            }
        });
    });

    // Function to update Add Product button visibility
    function updateAddProductButton() {
        let hasSelectedProduct = false;
        $('.product-type').each(function() {
            if ($(this).val() !== '') {
                hasSelectedProduct = true;
                return false; // break the loop
            }
        });

        if (hasSelectedProduct) {
            $('#addProductRow').show();
            // Show remove button for all rows
            $('.remove-product-row').show();
        } else {
            $('#addProductRow').hide();
            // Hide remove button for first row only
            $('#productsTableBody tr:first .remove-product-row').hide();
        }
    }
});

// Helper function to format field names
function formatFieldName(field) {
    const fieldMap = {
        'dealer_name': 'Dealer Name',
        'dealer_state': 'Dealer State',
        'dealer_city': 'Dealer City',
        'invoice_number': 'Invoice Number',
        'upload_invoice': 'Invoice File',
        'product_type_id': 'Product Type',
        'variant_id': 'Variant',
        'variant': 'Variant',
        'product_name_design': 'Product Name/Design',
        'product_category': 'Product Category',
        'no_of_boxes': 'No. of Boxes',
        'quantity': 'Quantity',
        'area_sqft': 'Area (Sq. Ft.)',
        'handover_certificate': 'Handover Certificate',
        'invoice_date': 'Invoice Date',
        'uom': 'UoM',
        'site_address': 'Site Address',
        'product_thickness': 'Product Thickness'
    };

    return fieldMap[field] || field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

// Function to show error message
function showErrorMessage(message) {
    $('#formErrors').removeClass('d-none alert-success').addClass('alert-danger').html(message);
    $('#formErrors').show();

    // Scroll to error message
    $('html, body').animate({
        scrollTop: $('#formErrors').offset().top - 100
    }, 500);
}

// Function to show success message
function showSuccessMessage(message) {
    $('#formErrors').removeClass('d-none alert-danger').addClass('alert-success').html(message);
    $('#formErrors').show();

    // Scroll to success message
    $('html, body').animate({
        scrollTop: $('#formErrors').offset().top - 100
    }, 500);
}

// Function to clear all error messages
function clearErrors() {
    $('#formErrors').addClass('d-none').removeClass('alert-danger alert-success').html('');
    $('.text-danger').text('');
}

// Function to get variants for a product type
function getVariantsForProduct(row, productTypeId) {
    $.get('/user/warranty/get-variants/' + productTypeId, function (variants) {
        let variantSelect = row.find('.variant-select');
        let variantInput = row.find('.variant-input');

        variantSelect.empty().append('<option value="">Select Variant</option>');

        if (variants.length > 0) {
            variantSelect.prop('disabled', false).show();
            variantInput.hide();

            variants.forEach(function (variant) {
                variantSelect.append('<option value="' + variant.id + '">' +
                    variant.variant_name + ' (' + variant.warranty_period + ')' +
                    (variant.usage_type ? ' - ' + variant.usage_type : '') + '</option>');
            });
        } else {
            variantSelect.prop('disabled', true).hide();
            variantInput.show();
        }
    }).fail(function() {
        showErrorMessage('Failed to load variants. Please try again.');
    });
}

// Function to auto-fill UoM based on product type
function autoFillUoM(row, productTypeName) {
    let uomInput = row.find('.uom-input');

    switch(productTypeName) {
        case 'Mikasa Ply':
        case 'Greenlam Clads':
        case 'MikasaFx':
        case 'Mikasa Doors':
            uomInput.val('PCS').prop('readonly', true);
            break;
        case 'Greenlam Sturdo':
            uomInput.val('PCS').prop('readonly', true);
            break;
        case 'Mikasa Floors':
            uomInput.val('Boxes').prop('readonly', true);
            break;
        default:
            uomInput.val('').prop('readonly', false);
    }
}

// Function to update row fields based on product type
function updateRowFields(row, productTypeName) {
    // Reset all fields first
    resetRowFields(row);

    // Apply field visibility based on product type
    switch (productTypeName) {
        case 'Mikasa Ply':
            showFields(row, ['variant-col', 'quantity-col', 'uom-col']);
            row.find('.variant-select').closest('td').show();
            row.find('.variant-input').hide();
            row.find('.quantity-input').prop('required', true);
            break;

        case 'Greenlam Clads':
            showFields(row, ['product-name-col', 'quantity-col', 'uom-col']);
            row.find('.variant-select').closest('td').hide();
            row.find('.variant-input').hide();
            row.find('.product-name-input').prop('required', true);
            row.find('.quantity-input').prop('required', true);
            break;

        case 'MikasaFx':
            showFields(row, ['product-name-col', 'quantity-col', 'site-address-col', 'uom-col']);
            row.find('.variant-select').closest('td').hide();
            row.find('.variant-input').hide();
            row.find('.product-name-input').prop('required', true);
            row.find('.quantity-input').prop('required', true);
            row.find('.site-address-input').prop('required', true);
            break;

        case 'Greenlam Sturdo':
            showFields(row, ['product-category-col', 'quantity-col', 'site-address-col', 'uom-col']);
            row.find('.variant-select').closest('td').hide();
            row.find('.variant-input').hide();
            row.find('.product-category-input').prop('required', true);
            row.find('.quantity-input').prop('required', true);
            row.find('.site-address-input').prop('required', true);
            break;

        case 'Mikasa Floors':
            showFields(row, ['variant-col', 'boxes-col', 'area-col', 'uom-col']);
            row.find('.variant-select').closest('td').show();
            row.find('.variant-input').hide();
            row.find('.boxes-input').prop('required', true);
            row.find('.area-input').prop('required', true);
            break;

        case 'Mikasa Doors':
            showFields(row, ['quantity-col', 'handover-col', 'thickness-col', 'site-address-col', 'uom-col']);
            row.find('.variant-select').closest('td').hide();
            row.find('.variant-input').hide();
            row.find('.handover-input').prop('required', true);
            row.find('.quantity-input').prop('required', true);
            row.find('.thickness-input').prop('required', true);
            break;

        default:
            // Hide all fields except product type
            resetRowFields(row);
            break;
    }
}

// Function to reset all fields in a row
function resetRowFields(row) {
    // Hide all columns except product type and action
    row.find('td').slice(1, -1).hide();

    // Reset all inputs
    row.find('input, select, textarea').each(function() {
        if (!$(this).hasClass('product-type')) {
            $(this).val('');
            $(this).removeAttr('required');
            $(this).prop('disabled', false);
            $(this).prop('readonly', false);
        }
    });

    // Hide variant input if it's visible
    row.find('.variant-input').hide();
    row.find('.variant-select').hide();

    // Clear file previews
    row.find('.handover-preview').empty();
}

// Function to show specific fields
function showFields(row, fieldClasses) {
    fieldClasses.forEach(function(fieldClass) {
        row.find('.' + fieldClass).closest('td').show();
    });
}
