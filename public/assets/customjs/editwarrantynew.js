
$(document).ready(function () {

    // Initialize fields for existing products
    $('.product-row').each(function() {
        if ($(this).data('status') === 'modify') {
            let row = $(this);
            let productTypeId = row.find('.product-type').val();
            let productTypeName = row.find('.product-type option:selected').text().trim();

            if (productTypeId) {
                updateRowFields(row, productTypeName);
                getVariantsForProduct(row, productTypeId);
                autoFillUoM(row, productTypeName);
            }
        }
    });

    // Handle product type change (if they change type of an editable product)
    $(document).on('change', '.product-type', function () {
        let row = $(this).closest('tr');
        let productTypeId = $(this).val();

        if (productTypeId) {
            let productTypeName = $(this).find('option:selected').text().trim();
            updateRowFields(row, productTypeName);
            getVariantsForProduct(row, productTypeId);
            autoFillUoM(row, productTypeName);
        } else {
            resetRowFields(row);
        }
    });

    // Handle variant select change
    $(document).on('change', '.variant-select', function () {
        let variantId = $(this).val();
        let variantInput = $(this).siblings('.variant-input');

        if (variantId) {
            variantInput.val('').hide();
        } else {
            let productTypeName = $(this).closest('tr').find('.product-type option:selected').text().trim();
            if (productTypeName === 'Mikasa Ply' || productTypeName === 'Mikasa Floors') {
                variantInput.show();
            }
        }
    });

    // State-City dropdown interaction
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

    // Trigger city load if state is already selected but city list might be empty (e.g. page reload)
    // Actually the blade handles pre-selection if the list was populated, but since we rely on ajax for cities list often:
    // We should trigger change or manually load if city is set but only one option exists.
    // However, for edit, we might just want to load cities if state is present.
    // But specific logic: if 'dealer_city' has value, we should ensure the list is populated.

    let initialState = $('#dealer_state').val();
    let selectedCity = $('#dealer_city').data('selected');

    if (initialState) {
         $.get('/get-cities/' + encodeURIComponent(initialState))
            .done(function (cities) {
                let citySelect = $('#dealer_city');
                citySelect.empty();
                 citySelect.append('<option value="">Select City</option>');
                cities.forEach(function (city) {
                     let isSelected = (city == selectedCity) ? 'selected' : '';
                    citySelect.append('<option value="' + city + '" '+isSelected+'>' + city + '</option>');
                });
            });
    }


    // Form submission
    $('#warrantyFormEdit').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        clearErrors();

        // Validate required fields for editable rows
        let isValid = true;
        let errorMessages = [];

        $('.product-row').each(function(index) {
             if ($(this).data('status') === 'modify') {
                let productTypeName = $(this).find('.product-type option:selected').text().trim();
                if (productTypeName) {
                    // Check required fields based on product type
                    // Reusing logic from create JS
                     switch(productTypeName) {
                        case 'Mikasa Ply':
                            let variantSelectPly = $(this).find('.variant-select').val();
                            let variantInputPly = $(this).find('.variant-input').val();
                            if (!variantSelectPly && !variantInputPly) {
                                errorMessages.push(`Product ${index + 1}: Variant is required for Mikasa Ply`);
                                isValid = false;
                            }
                            if (!$(this).find('.quantity-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Quantity is required for Mikasa Ply`);
                                isValid = false;
                            }
                            break;
                         // ... reuse other cases
                        case 'Mikasa Floors':
                            let variantSelectFloors = $(this).find('.variant-select').val();
                            let variantInputFloors = $(this).find('.variant-input').val();
                             if (!variantSelectFloors && !variantInputFloors) {
                                errorMessages.push(`Product ${index + 1}: Variant is required for Mikasa Floors`);
                                isValid = false;
                            }
                            if (!$(this).find('.boxes-input').val()) {
                                errorMessages.push(`Product ${index + 1}: No. of Boxes is required for Mikasa Floors`);
                                isValid = false;
                            }
                            if (!$(this).find('.area-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Area is required for Mikasa Floors`);
                                isValid = false;
                            }
                            break;
                        case 'Mikasa Doors':
                             if (!$(this).find('.quantity-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Quantity is required for Mikasa Doors`);
                                isValid = false;
                            }
                             // Handover certificate not required on Edit if already exists?
                             // We should only enforce if file is new?
                             // Logic: If hidden input or existing file link exists, it might be fine.
                             // But since we don't track existing file presence in JS easily without extra fields:
                             // Let's assume validation is handled by backend mostly or lenient here.
                             // BUT, for text fields we enforce.

                             if (!$(this).find('.thickness-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Product Thickness is required for Mikasa Doors`);
                                isValid = false;
                            }
                            break;
                         case 'Greenlam Clads':
                            if (!$(this).find('.product-name-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Product Name/Design is required for Greenlam Clads`);
                                isValid = false;
                            }
                            if (!$(this).find('.quantity-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Quantity is required for Greenlam Clads`);
                                isValid = false;
                            }
                            break;
                        case 'MikasaFx':
                             if (!$(this).find('.product-name-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Product Name/Design is required for MikasaFx`);
                                isValid = false;
                            }
                            if (!$(this).find('.quantity-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Quantity is required for MikasaFx`);
                                isValid = false;
                            }
                             if (!$(this).find('.site-address-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Site Address is required for MikasaFx`);
                                isValid = false;
                            }
                            break;
                        case 'Greenlam Sturdo':
                             if (!$(this).find('.product-category-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Product Category is required for Greenlam Sturdo`);
                                isValid = false;
                            }
                            if (!$(this).find('.quantity-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Quantity is required for Greenlam Sturdo`);
                                isValid = false;
                            }
                             if (!$(this).find('.site-address-input').val()) {
                                errorMessages.push(`Product ${index + 1}: Site Address is required for Greenlam Sturdo`);
                                isValid = false;
                            }
                            break;
                     }
                }
             }
        });

        if (!isValid) {
            showErrorMessage('<ul>' + errorMessages.map(msg => `<li>${msg}</li>`).join('') + '</ul>');
            return;
        }

        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

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
                    setTimeout(function() {
                        window.location.href = "/user/warranties"; // Redirect to list
                    }, 2000);
                } else {
                    showErrorMessage(response.message);
                }
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).html(originalText);
                if (xhr.status === 422) {
                     let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (field, messages) {
                        errorHtml += '<li>' + messages[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    showErrorMessage(errorHtml);
                } else {
                     showErrorMessage('An error occurred. Please try again.');
                }
            }
        });
    });

     // Functions reused/adapted from create JS

    function getVariantsForProduct(row, productTypeId) {
        $.get('/user/warranty/get-variants/' + productTypeId, function (variants) {
            let variantSelect = row.find('.variant-select');
            let variantInput = row.find('.variant-input');
            let selectedVariant = variantSelect.data('selected');

            variantSelect.empty().append('<option value="">Select Variant</option>');

            if (variants.length > 0) {
                variantSelect.prop('disabled', false).show();
                variantInput.hide();

                variants.forEach(function (variant) {
                    let isSelected = (variant.id == selectedVariant) ? 'selected' : '';
                    variantSelect.append('<option value="' + variant.id + '" '+isSelected+'>' +
                        variant.variant_name + ' (' + variant.warranty_period + ')' +
                        (variant.usage_type ? ' - ' + variant.usage_type : '') + '</option>');
                });
            } else {
                variantSelect.prop('disabled', true).hide();
                variantInput.show();
            }
        });
    }

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
                uomInput.prop('readonly', false);
        }
    }

    function updateRowFields(row, productTypeName) {
        // Reset row fields visibility excluding product type
        row.find('td').slice(1).hide();

        // Helper to show cols
        // Note: index in slice depends on column index.
        // 0: product type
        // 1: variant
        // 2: product name/design
        // 3: product category
        // 4: boxes
        // 5: quantity
        // 6: area
        // 7: handover
        // 8: invoice no
        // 9: invoice date
        // 10: uom
        // 11: site address
        // 12: thickness

        // This relies on class names which is safer.

        switch (productTypeName) {
            case 'Mikasa Ply':
                showFields(row, ['variant-col', 'quantity-col', 'uom-col']);
                row.find('.variant-select').closest('td').show();
                row.find('.variant-input').hide();
                break;
            case 'Greenlam Clads':
                showFields(row, ['product-name-col', 'quantity-col', 'uom-col']);
                break;
            case 'MikasaFx':
                showFields(row, ['product-name-col', 'quantity-col', 'site-address-col', 'uom-col']);
                break;
            case 'Greenlam Sturdo':
                showFields(row, ['product-category-col', 'quantity-col', 'site-address-col', 'uom-col']);
                break;
            case 'Mikasa Floors':
                showFields(row, ['variant-col', 'boxes-col', 'area-col', 'uom-col']);
                row.find('.variant-select').closest('td').show();
                row.find('.variant-input').hide();
                break;
            case 'Mikasa Doors':
                showFields(row, ['quantity-col', 'handover-col', 'thickness-col', 'site-address-col', 'uom-col']);
                break;
        }
    }

    function showFields(row, fieldClasses) {
        fieldClasses.forEach(function(fieldClass) {
            row.find('.' + fieldClass).closest('td').show();
        });
    }

    function resetRowFields(row) {
        row.find('td').slice(1).hide();
        // Clear inputs? Maybe not for edit if they just misclicked.
    }

    function clearErrors() {
        $('#formErrors').addClass('d-none').html('');
        $('.text-danger').text('');
    }

    function showErrorMessage(message) {
        $('#formErrors').removeClass('d-none alert-success').addClass('alert-danger').html(message);
        $('#formErrors').show();
        $('html, body').animate({ scrollTop: $('#formErrors').offset().top - 100 }, 500);
    }

    function showSuccessMessage(message) {
         $('#formErrors').removeClass('d-none alert-danger').addClass('alert-success').html(message);
        $('#formErrors').show();
        $('html, body').animate({ scrollTop: $('#formErrors').offset().top - 100 }, 500);
    }

});
