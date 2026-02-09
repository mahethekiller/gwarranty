// warranty-edit.js
$(document).ready(function() {
    // Initialize popovers for admin remarks
    $(document).on('click', '.admin-remarks-btn', function() {
        const remarks = $(this).data('remarks');
        $(this).popover({
            container: 'body',
            placement: 'top',
            trigger: 'focus',
            content: remarks,
            title: 'Admin Remarks',
            template: '<div class="popover admin-remarks-popover" role="tooltip">' +
                      '<div class="popover-arrow"></div>' +
                      '<h3 class="popover-header"></h3>' +
                      '<div class="popover-body"></div>' +
                      '</div>'
        }).popover('toggle');
    });

    // AJAX for loading variants
    $(document).on('change', '.product-type-select', function() {
        const productId = $(this).data('product-id');
        const productTypeId = $(this).val();

        if (!productTypeId) {
            $(`.variant-field[data-product-id="${productId}"]`).hide();
            return;
        }

        // Show loading in variant select
        const variantSelect = $(`.variant-select[data-product-id="${productId}"]`);
        variantSelect.html('<option value="">Loading variants...</option>');
        variantSelect.prop('disabled', true);

        // Fetch variants
        const url = window.warrantyRoutes.getVariants.replace(':productTypeId', productTypeId);

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Variant</option>';
                if (response && response.length > 0) {
                    response.forEach(variant => {
                        options += `<option value="${variant.variant_name}">${variant.variant_name}</option>`;
                    });
                }
                variantSelect.html(options);
                variantSelect.prop('disabled', false);
                $(`.variant-field[data-product-id="${productId}"]`).show();
            },
            error: function(xhr) {
                console.error('Error loading variants:', xhr);
                variantSelect.html('<option value="">Error loading variants</option>');
                variantSelect.prop('disabled', false);
            }
        });

        // Fetch field configuration
        fetchFieldConfig(productId, productTypeId);
    });

    // Fetch field configuration
    function fetchFieldConfig(productId, productTypeId) {
        const url = window.warrantyRoutes.getProductFields.replace(':productTypeId', productTypeId);

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    updateDynamicFields(productId, response.config, response.product_type_name);
                } else {
                    console.error('Failed to fetch field config:', response.message);
                }
            },
            error: function(xhr) {
                console.error('Error fetching field config:', xhr);
            }
        });
    }

    // Update dynamic fields based on configuration
    function updateDynamicFields(productId, config, productTypeName) {
        const fieldsContainer = $(`.dynamic-fields[data-product-id="${productId}"]`);
        let html = '';

        if (config.fields && config.fields.length > 0) {
            html = '<div class="row">';
            config.fields.forEach(field => {
                if (field !== 'variant') {
                    const isRequired = config.required && config.required.includes(field);
                    const label = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                    html += `
                        <div class="col-md-6 mb-3">
                            <label class="form-label ${isRequired ? 'required-field' : ''}">${label}</label>`;

                    if (field === 'product_category') {
                        html += `
                            <select class="form-control" name="products[${productId}][${field}]" ${isRequired ? 'required' : ''}>
                                <option value="">Select Category</option>
                                <option value="Interior">Interior</option>
                                <option value="Exterior">Exterior</option>
                            </select>`;
                    } else if (field === 'handover_certificate') {
                        html += `
                            <select class="form-control" name="products[${productId}][${field}]" ${isRequired ? 'required' : ''}>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>`;
                    } else {
                        const inputType = ['area_sqft', 'quantity', 'no_of_boxes'].includes(field) ? 'number' : 'text';
                        const step = field === 'area_sqft' ? '0.01' : '1';
                        html += `
                            <input type="${inputType}" class="form-control dynamic-field-input"
                                   name="products[${productId}][${field}]"
                                   step="${step}" ${isRequired ? 'required' : ''}>`;
                    }

                    html += `</div>`;
                }
            });
            html += '</div>';
        }

        fieldsContainer.html(html);

        // Update UOM if auto_fill exists
        const uomField = $(`.uom-field[name="products[${productId}][uom]"]`);
        if (config.auto_fill && config.auto_fill.uom) {
            uomField.val(config.auto_fill.uom);
        }
    }

    // Form submission
    $('#editProductsForm').on('submit', function(e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to submit these changes? The products will be sent back for admin review.')) {
            return;
        }

        const formData = $(this).serialize();
        const submitBtn = $('#submitBtn');
        const loadingOverlay = $('#loadingOverlay');
        const form = $(this);
        const actionUrl = form.attr('action');

        // Validate required fields before submission
        let isValid = true;
        $('.required-field').each(function() {
            const input = $(this).closest('.mb-3').find('select, input');
            if (input.length && input.prop('required') && !input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            showAlert('danger', 'Please fill in all required fields.');
            return;
        }

        // Show loading
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        loadingOverlay.show();

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    setTimeout(() => {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    }, 1500);
                } else {
                    showAlert('danger', response.message);
                    if (response.errors) {
                        // Display individual product errors
                        for (const [productId, errors] of Object.entries(response.errors)) {
                            const card = $(`#product-card-${productId}`);
                            card.addClass('border-danger');
                            const errorHtml = errors.map(error =>
                                `<div class="text-danger"><i class="fa fa-exclamation-circle"></i> ${error}</div>`
                            ).join('');
                            card.find('.product-body').prepend(`<div class="alert alert-danger">${errorHtml}</div>`);

                            // Scroll to first error
                            $('html, body').animate({
                                scrollTop: card.offset().top - 100
                            }, 500);
                        }
                    }
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating products.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    message = 'Validation error occurred. Please check your inputs.';
                }
                showAlert('danger', message);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fa fa-check"></i> Submit Updates');
                loadingOverlay.hide();
            }
        });
    });

    // Real-time validation for required fields
    $(document).on('blur', 'select[required], input[required]', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        } else {
            $(this).addClass('is-invalid');
        }
    });

    // Show alert function
    function showAlert(type, message) {
        // Remove existing alerts
        $('.alert-dismissible').remove();

        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fa ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('.card-body').prepend(alertHtml);

        // Auto-dismiss success alerts after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                $('.alert-success').alert('close');
            }, 5000);
        }
    }

    // Trigger change event for existing product types to load variants
    $('.product-type-select').each(function() {
        if ($(this).val()) {
            $(this).trigger('change');
        }
    });
});
