<form action="{{ route('admin.users.update', $user->id) }}" id="editUserForm">
    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">

    <div class="form-group row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="name" class="form-label custom-form-label">Name</label>
                <input class="form-control" id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}" placeholder="Enter Your Name">
                <span class="text-danger" id="error-name" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="email" class="form-label custom-form-label">Enter Email Id</label>
                <input class="form-control" id="email" name="email" type="text"
                    value="{{ old('email', $user->email) }}" disabled>
                <span class="text-danger" id="error-email" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="phone" class="form-label custom-form-label">Phone Number</label>
                <input class="form-control" id="phone_number" name="phone_number" type="text"
                    value="{{ old('phone_number', $user->phone_number) }}" placeholder="Enter Phone Number">
                <span class="text-danger" id="error-phone_number" role="alert">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="password" class="form-label custom-form-label">Create Password</label>
                <input class="form-control" id="password" name="password" type="password"
                    placeholder="Enter Your Password">
                <span class="text-danger" id="error-password" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="product_type" class="form-label custom-form-label">Product Type</label>
                <select class="form-multi-select2 selectpicker" multiple name="product_type[]">
                    <option value="0"
                        {{ in_array('0', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>Mikasa
                        Floors</option>
                    <option value="1"
                        {{ in_array('1', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>Mikasa
                        Doors</option>
                    <option value="2"
                        {{ in_array('2', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>Mikasa
                        Ply</option>
                    <option value="3"
                        {{ in_array('3', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>Greenlam
                        Clads</option>
                    <option value="4"
                        {{ in_array('4', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>NewMikaFx
                    </option>
                    <option value="5"
                        {{ in_array('5', old('product_type', $user->product_type ?? [])) ? 'selected' : '' }}>Greenlam
                        Sturdo</option>
                </select>
                <span class="text-danger" id="error-product_type" role="alert">
                    <strong>{{ $errors->first('product_type') }}</strong>
                </span>
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
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var user_id = $('#user_id').val();

        // Reset error fields
        let errorFields = ['#error-name', '#error-email', '#error-phone_number', '#error-password',
            '#error-product_type'
        ];
        errorFields.forEach(field => {
            $(field).text('');
        });

        $.ajax({
            url: '/admin/user/update/' + user_id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('User updated successfully');
                $('#userEditModal').modal('hide');
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
