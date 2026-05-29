<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product-variants.add') }}" id="productVariantForm" method="POST">
                        @csrf
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="product_type_id" class="form-label custom-form-label">Product Type</label>
                                    <select class="form-control" id="product_type_id" name="product_type_id">
                                        <option value="" selected disabled>Select Product Type</option>
                                        @foreach ($productTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('product_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error-product_type_id" role="alert">
                                        <strong>{{ $errors->first('product_type_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="variant_name" class="form-label custom-form-label">Variant Name</label>
                                    <input class="form-control" id="variant_name" name="variant_name" type="text"
                                        value="{{ old('variant_name') }}" placeholder="e.g. BWP Plus Plywood">
                                    <span class="text-danger" id="error-variant_name" role="alert">
                                        <strong>{{ $errors->first('variant_name') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="warranty_period" class="form-label custom-form-label">Warranty Period</label>
                                    <input class="form-control" id="warranty_period" name="warranty_period" type="text"
                                        value="{{ old('warranty_period') }}" placeholder="e.g. 20 yrs">
                                    <span class="text-danger" id="error-warranty_period" role="alert">
                                        <strong>{{ $errors->first('warranty_period') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="usage_type" class="form-label custom-form-label">Usage Type (Optional)</label>
                                    <input class="form-control" id="usage_type" name="usage_type" type="text"
                                        value="{{ old('usage_type') }}" placeholder="e.g. Residential/Commercial">
                                    <span class="text-danger" id="error-usage_type" role="alert">
                                        <strong>{{ $errors->first('usage_type') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button class="custom-btn-blk">Save Variant</button>
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
                    <h4 class="pb-1">Product Variant List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Product Type</th>
                                    <th>Variant Name</th>
                                    <th>Warranty</th>
                                    <th>Usage Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $key => $variant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $variant->productType->name }}</td>
                                        <td>{{ $variant->variant_name }}</td>
                                        <td>{{ $variant->warranty_period }}</td>
                                        <td>{{ $variant->usage_type ?? 'N/A' }}</td>
                                        <td>
                                            @if ($variant->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="pending-icon-red edit-variant-btn"
                                                data-bs-toggle="modal" data-bs-target="#variantEditModal"
                                                data-id="{{ $variant->id }}"><i
                                                    class="fa fa-pencil"></i> &nbsp;Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $variants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="variantEditModal" tabindex="-1" aria-labelledby="variantEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header paoc-popup-mheading">
                    <h5 class="modal-title" id="variantEditModalLabel">Edit Product Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="variantEditModalBody">
                    <!-- Loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).on('click', '.edit-variant-btn', function() {
            var id = $(this).data('id');
            $('#variantEditModalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
            $.get("{{ url('admin/product-variant') }}/" + id + "/edit", function(data) {
                $('#variantEditModalBody').html(data);
            });
        });
    </script>
    @endpush
</x-userdashboard-layout>
