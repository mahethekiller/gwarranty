$('#profileForm').on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let formData = form.serialize();

    // Clear previous errors
    $('.text-danger').text('');

    $.ajax({
        url: form.attr('action'),
        method: "POST",
        data: formData,
        success: function(response) {
            alert('Profile saved successfully!');
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    $('#error-' + field).text(messages[0]);
                });
            } else {
                alert('Something went wrong.');
            }
        }
    });
});
