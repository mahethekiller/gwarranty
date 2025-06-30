$(document).on('click', '[data-bs-target="#userEditModal"]', function (e) {
    e.preventDefault();
    var userId = $(this).data('id'); // Retrieve ID from the clicked element's data-id attribute
    $('#userEditModal form').data('warranty-id', userId);

    // Fetch warranty data from server
    $.ajax({
        url: '/admin/user/'+userId+'/edit/',
        type: 'GET',
        success: function (response) {
            // debugger

            if(response.message){
                alert(response.message);
            }else{
                $('#userEditModalBody').html(response);

            }
        },
        error: function (xhr) {
            alert('Error fetching data');
            console.log(xhr.responseText);
        }
    });
});



