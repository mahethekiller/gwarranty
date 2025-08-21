@php
    $fixedWarranties = [
        4 => '12 yrs',
        2 => '5 yrs',
        6 => '10 yrs',
        5 => '10 yrs',
    ];
    $fixedWarranty = $fixedWarranties[$product->product_type] ?? '';
@endphp

<div class="col-md-6">
    <label class="form-label">Product Name</label>
    <input type="text" class="form-control product_name_input" name="product_name[{{ $index }}]"
        value="{{ $product->product_name ?? '' }}">
</div>
<div class="col-md-6">
    <label class="form-label">Warranty</label>
    <input type="text" name="warranty_years[{{ $index }}]" value="{{ $fixedWarranty }}" readonly class="warranty_hidden form-control">
</div>

