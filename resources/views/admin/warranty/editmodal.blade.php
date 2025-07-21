<form action="" id="editWarrantyForm">
    @csrf

    <input type="hidden" name="warranty_id" id="warranty_id" value="{{ $warranty->id }}" />

    <div class="form-group row">


        {{-- <div class="col-lg-12">
            <div class="form-group">
                <label for="remarks" class="form-label custom-form-label">Overall Remarks</label>
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
        </div> --}}


    </div>


    <div class="form-group row">

        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Purchased</th>
                        <th>Application Type</th>
                        <th>Total Quantity</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($warrantyProducts as $index => $product)
                        <input type="hidden" name="product_id[{{ $index }}]" value="{{ $product->id }}" />

                        <tr>
                            <td>

                                <p>{{ $product->product->name }}</p>
                            </td>
                            <td>

                                <p>{{ $product->qty_purchased }}</p>
                            </td>
                            <td>

                                <p>{{ $product->application_type ?: 'N/A' }}</p>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="number" class="form-control"
                                        name="total_quantity[{{ $index }}]"
                                        value="{{ $product->total_quantity }}" placeholder="Enter Total Quantity" />
                                </div>
                            </td>


                            <td>
                                <p>
                                <div class="form-group">
                                    <select class="form-control" name="product_status[{{ $index }}]">
                                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="modify" {{ $product->status == 'modify' ? 'selected' : '' }}>
                                            Modify</option>
                                        <option value="approved"
                                            {{ $product->status == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                    </select>
                                </div>
                                </p>
                            </td>
                            <td>

                                <p>
                                <div class="form-group">
                                    <textarea class="form-control" name="product_remarks[{{ $index }}]" placeholder="Enter Remarks">{{ $product->remarks }}</textarea>
                                </div>
                                </p>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-12" id="error-messages">

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
        $('#error-messages').html('');

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
                    $('#error-messages').html('');
                    for (let field in errors) {
                        $('#error-messages').append(`<span class="text-danger">${errors[field][0]}</span><br>`);
                    }
                }
            }
        });
    });
</script>
