
// Handle edit warranty modal population
$(document).on('click', '[data-bs-target="#editWarrantyModel"]', function (e) {
    e.preventDefault();
    var warrantyId = $(this).data('id'); // Retrieve ID from the clicked element's data-id attribute

    // Fetch warranty data from server
    $.ajax({
        url: '/admin/warranty/edit/' + warrantyId,
        type: 'GET',
        success: function (response) {
            // debugger

            if(response.message){
                alert(response.message);
            }else{
                $('#editWarrantyModelBody').html(response);
            }

        },
        error: function (xhr) {
            alert('Error fetching warranty data');
            console.log(xhr.responseText);
        }
    });
});


$(document).ready(function() {
    $('#warrantyTable').DataTable();
});


