<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product-types.add') }}" id="productTypeForm" method="POST">
                        @csrf
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label custom-form-label">Product Type Name</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                        value="{{ old('name') }}" placeholder="e.g. Mikasa Ply">
                                    <span class="text-danger" id="error-name" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sort_order" class="form-label custom-form-label">Sort Order</label>
                                    <input class="form-control" id="sort_order" name="sort_order" type="number"
                                        value="{{ old('sort_order', 0) }}">
                                    <span class="text-danger" id="error-sort_order" role="alert">
                                        <strong>{{ $errors->first('sort_order') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button class="custom-btn-blk">Save Product Type</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="pb-1">Product Type List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productTypes as $key => $type)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $type->name }}</td>
                                        <td>{{ $type->slug }}</td>
                                        <td>{{ $type->sort_order }}</td>
                                        <td>
                                            @if ($type->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="pending-icon-red edit-type-btn"
                                                data-bs-toggle="modal" data-bs-target="#typeEditModal"
                                                data-id="{{ $type->id }}"><i
                                                    class="fa fa-pencil"></i> &nbsp;Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $productTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="typeEditModal" tabindex="-1" aria-labelledby="typeEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="typeEditModalLabel">Edit Product Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="typeEditModalBody">
                    <!-- Loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).on('click', '.edit-type-btn', function() {
            var id = $(this).data('id');
            $('#typeEditModalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
            $.get("{{ url('admin/product-type') }}/" + id + "/edit", function(data) {
                $('#typeEditModalBody').html(data);
            });
        });
    </script>
    @endpush
</x-userdashboard-layout>
