<form action="{{ route('admin.product-types.update', $productType->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="edit_name" class="form-label custom-form-label">Product Type Name</label>
                <input class="form-control" id="edit_name" name="name" type="text"
                    value="{{ $productType->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="edit_sort_order" class="form-label custom-form-label">Sort Order</label>
                <input class="form-control" id="edit_sort_order" name="sort_order" type="number"
                    value="{{ $productType->sort_order }}">
            </div>
            <div class="form-group mb-3">
                <label for="edit_is_active" class="form-label custom-form-label">Status</label>
                <select class="form-control" id="edit_is_active" name="is_active">
                    <option value="1" {{ $productType->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$productType->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Product Type</button>
    </div>
</form>
