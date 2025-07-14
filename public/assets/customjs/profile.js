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


document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    stateSelect.addEventListener('change', function () {
        const selectedState = this.value;

        // Clear city dropdown
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (selectedState) {
            fetch(`/get-cities/${encodeURIComponent(selectedState)}`)
                .then(response => response.json())
                .then(cities => {
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        citySelect.appendChild(option);
                    });
                });
        }
    });
});

