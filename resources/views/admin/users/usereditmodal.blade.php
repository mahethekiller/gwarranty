<form action="{{ route('admin.users.update', $user->id) }}" id="editUserForm">
    @csrf
    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">

    <div class="form-group row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="name" class="form-label custom-form-label">Name</label>
                <input class="form-control" id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}" placeholder="Enter Your Name">
                <span class="text-danger" id="modalerror-name" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="role" class="form-label custom-form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="" selected>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" data-role-name="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="error-role" role="alert">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6" id="branch_name_div">
            <div class="form-group">
                <label for="branch_name" class="form-label custom-form-label">Branch Name</label>
                <select class="form-control" id="branch_name" name="branch_name">
                    <option value="" selected>Select Branch Name</option>
                    @foreach ($branchNames as $branchName)
                        <option value="{{ $branchName }}" {{ old('branch_name') == $branchName ? 'selected' : '' }}>
                            {{ $branchName }}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="error-branch_name" role="alert">
                    <strong>{{ $errors->first('branch_name') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="email" class="form-label custom-form-label">Enter Email Id</label>
                <input class="form-control" id="email" name="email" type="text"
                    value="{{ old('email', $user->email) }}" readonly>
                <span class="text-danger" id="modalerror-email" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="phone" class="form-label custom-form-label">Phone Number</label>
                <input class="form-control" id="phone_number" name="phone_number" type="text"
                    value="{{ old('phone_number', $user->phone_number) }}" placeholder="Enter Phone Number">
                <span class="text-danger" id="modalerror-phone_number" role="alert">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="password" class="form-label custom-form-label">Create Password</label>
                <input class="form-control" id="password" name="password" type="password"
                    placeholder="Enter Your Password">
                <span class="text-danger" id="modalerror-password" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-lg-6" id="product-type-wrapper"
            style="display: {{ $user->hasRole('country_admin') ? 'block' : 'none' }}">
            <div class="form-group">
                <label for="product_type" class="form-label custom-form-label">Product Type</label>
                <br>
                <select class="form-control" name="product_type" style="width: 100%">
                    <option value="" selected>Select Product Type</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $product_id ? 'selected' : '' }}>
                            {{ $product->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger" id="modalerror-product_type" role="alert">
                    <strong>{{ $errors->first('product_type') }}</strong>
                </span>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label for="status" class="form-label custom-form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                        Inactive</option>
                </select>
                <span class="text-danger" id="modalerror-status" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
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
        let errorFields = ['#modalerror-name', '#modalerror-email', '#modalerror-phone_number',
            '#modalerror-password',
            '#modalerror-product_type'
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
                // debugger
                location.reload(); // Reload to reflect changes
            },
            error: function(xhr) {
                // alert('Error updating warranty');
                // console.log(xhr.responseText);
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    console.log(errors[field][0]);

                    $(`#modalerror-${field}`).text(errors[field][0]);
                }
            }
        });
    });



    function toggleProductType() {
        var selectedRole = $("#role option:selected").data("role-name");

        if (selectedRole === "country_admin") {
            $("#product-type-wrapper").show();
        } else {
            $("#product-type-wrapper").hide();
        }
    }

    function toggleBranchNameDiv() {
        var selectedRole = $("#role option:selected").data("role-name");

        if (selectedRole === "branch_admin") {
            $("#branch_name_div").show();
        } else {
            $("#email").prop("readonly", false).val("");
            $("#branch_name_div").hide();
        }
    }

    $(document).ready(function() {
        toggleProductType(); // on page load
        toggleBranchNameDiv();
        $("#role").on("change", function() {
            toggleProductType();
            toggleBranchNameDiv();
        });
    });

    $("#branch_name").on("change", function() {
        var branchName = $(this).val();

        if (branchName) {
            $.ajax({
                url: adminurl + "/get-branch-email",
                method: "GET",
                data: {
                    branch_name: branchName
                },
                success: function(response) {
                    $("#email").val(response.email || "");
                    $("#email").prop("readonly", true);


                    if (response.exists) {
                        $("#error-email").text("A user with this branch email already exists!");
                        $("#email").addClass("is-invalid");
                    } else {
                        $("#email").removeClass("is-invalid");
                        $("#error-email").text("");
                    }
                },
                error: function() {
                    $("#email").val("");
                    $("#email").removeClass("is-invalid");
                },
            });
        } else {
            $("#email").val("");
            $("#email").removeClass("is-invalid");
        }
    });
</script>
