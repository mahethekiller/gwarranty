<form action="" id="editWarrantyForm">
    @csrf

    <input type="hidden" name="warranty_id" id="warranty_id" value="{{ $warranty->id }}" />

    <div class="form-group row">


        <div class="col-lg-12">
            <div class="form-group">
                <label for="remarks" class="form-label custom-form-label">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks">{{ $warranty->remarks }}</textarea>
                <span class="text-danger" id="error-remarks" role="alert"></span>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="status" class="form-label custom-form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="pending" {{ $warranty->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="modify" {{ $warranty->status == 'modify' ? 'selected' : '' }}>Modify</option>
                    <option value="approved" {{ $warranty->status == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
                <span class="text-danger" id="error-status" role="alert"></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <div class="form-group">
                <button class="custom-btn-blk">Submit</button>
            </div>
        </div>
    </div>
</form>


<script>


    // Handle edit warranty form submission
    $('#editWarrantyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var warrantyId = $('#warranty_id').val();

        // Reset error fields
        let errorFields = ['#error-status', '#error-remark'];
        errorFields.forEach(field => {
            $(field).text('');
        });

        $.ajax({
            url: '/admin/warranty/update/' + warrantyId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Warranty updated successfully');
                $('#editWarrantyModel').modal('hide');
                location.reload(); // Reload to reflect changes
            },
            error: function(xhr) {
                // alert('Error updating warranty');
                // console.log(xhr.responseText);
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    console.log(errors[field][0]);

                    $(`#error-${field}`).text(errors[field][0]);
                }
            }
        });
    });



</script>
