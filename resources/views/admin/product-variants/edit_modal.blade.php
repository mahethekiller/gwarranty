<form action="{{ route('admin.product-variants.update', $variant->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="edit_product_type_id" class="form-label custom-form-label">Product Type</label>
                <select class="form-control" id="edit_product_type_id" name="product_type_id" required>
                    @foreach ($productTypes as $type)
                        <option value="{{ $type->id }}" {{ $variant->product_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="edit_variant_name" class="form-label custom-form-label">Variant Name</label>
                <input class="form-control" id="edit_variant_name" name="variant_name" type="text"
                    value="{{ $variant->variant_name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="edit_warranty_period" class="form-label custom-form-label">Warranty Period</label>
                <input class="form-control" id="edit_warranty_period" name="warranty_period" type="text"
                    value="{{ $variant->warranty_period }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="edit_usage_type" class="form-label custom-form-label">Usage Type</label>
                <input class="form-control" id="edit_usage_type" name="usage_type" type="text"
                    value="{{ $variant->usage_type }}">
            </div>
            <div class="form-group mb-3">
                <label for="edit_status" class="form-label custom-form-label">Status</label>
                <select class="form-control" id="edit_status" name="is_active">
                    <option value="1" {{ $variant->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$variant->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Variant</button>
    </div>
</form>
