<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.add') }}" id="userForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label custom-form-label">Name</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                        value="{{ old('name') }}" placeholder="Enter Your Name">
                                    <span class="text-danger" id="error-name" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email" class="form-label custom-form-label">Email Id</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        value="{{ old('email') }}" placeholder="Enter Email Id">
                                    <span class="text-danger" id="error-email" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone_number" class="form-label custom-form-label">Phone Number</label>
                                    <input class="form-control" id="phone_number" name="phone_number" type="text"
                                        value="{{ old('phone_number') }}" placeholder="Enter Your Number">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label custom-form-label">Confirm
                                        Password</label>
                                    <input class="form-control" id="password_confirmation" name="password_confirmation"
                                        type="password" placeholder="Confirm Password">
                                    <span class="text-danger" id="error-password_confirmation" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="select_product_type" class="form-label custom-form-label">Product
                                        Type</label>
                                    {{-- {{ print_r($users) }} --}}
                                    <select class="form-multi-select selectpicker" multiple data-coreui-search="true"
                                        name="product_type[]">
                                        {{-- <option value="" selected>Select Product Type</option> --}}

                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ in_array($product->id, old('product_type', [])) ? 'selected' : '' }}>
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error-product_type" role="alert">
                                        <strong>{{ $errors->first('product_type') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button class="custom-btn-blk">Save Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- User list --}}

    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="col-md-12 col-xl-12">
                                <h4 class="pb-1">User List</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Product Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_number }}</td>
                                                    @php
                                                        $productIds = explode(',', \App\Models\UserProduct::where('user_id', $user->id)->value('product_id'));
                                                        $productName = \App\Models\Product::whereIn('id', $productIds)->pluck('name')->implode(', ');
                                                    @endphp

                                                    <td>{{ $productName }}</td>
                                                    <td>
                                                        @if ($user->status === 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)"
                                                            class="pending-icon-red"
                                                            data-bs-toggle="modal" data-bs-target="#userEditModal"
                                                            data-id="{{ $user->id }}"><i
                                                                class="fa fa-pencil"></i> &nbsp;Edit</a>


                                                    </td>
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="userEditModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userEditModalBody">

                </div>
            </div>
        </div>
    </div>

</x-userdashboard-layout>
