@php
    $variants = json_decode($product->product_thickness ?? '[]', true);
    // $variants should be like [{"thickness":"1.5","quantity":"2"}, ...]
@endphp

<div class="card mb-3">
    <div class="card-header">Product Variants</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0" id="product-variants-table">
            <thead class="table-light">
                <tr>
                    <th>Thickness</th>
                    <th>Quantity</th>
                    <th style="width:100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($variants) && count($variants) > 0)
                    @foreach($variants as $index => $variant)
                        <tr class="variant-row">
                            <td>
                                <input type="text" name="product_thickness[]" class="form-control"
                                    value="{{ $variant['thickness'] ?? '' }}" placeholder="Thickness">
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control"
                                    value="{{ $variant['quantity'] ?? '' }}" placeholder="Quantity">
                            </td>
                            <td class="text-center">
                                @if($index === 0)
                                    <button type="button" class="btn btn-success btn-sm add-variant">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger btn-sm remove-variant">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="variant-row">
                        <td>
                            <input type="text" name="product_thickness[]" class="form-control" placeholder="Thickness">
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" placeholder="Quantity">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm add-variant">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
