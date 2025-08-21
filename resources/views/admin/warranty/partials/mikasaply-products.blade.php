{{-- <div class="col-md-6">
    <label class="form-label">Product Name</label>
    <select class="form-control product_name_select" name="product_name[{{ $index }}]">
        <option value="">Select Product Type</option>
        @php
            $types = $product->product->product_types ? json_decode($product->product->product_types, true) : [];
        @endphp
        @foreach ($types as $type)
            <option value="{{ $type['type'] }}" data-warranty="{{ $type['warranty'] }}"
                {{ $product->product_name == $type['type'] ? 'selected' : '' }}>
                {{ $type['type'] }}
            </option>
        @endforeach
    </select>
</div>
<input type="hidden" name="warranty_years[{{ $index }}]" class="warranty_hidden"
    value="{{ $product->warranty_years ?? '' }}"> --}}

<script>
    var productTypes = @json($product->product->product_types ? json_decode($product->product->product_types, true) : []);
</script>

@php
    $productTypes = $product->product->product_types ? json_decode($product->product->product_types, true) : [];

    // $productsjson = $product->products_json ?? [];
    $productsjson = !empty($product->products_json)
        ? (is_array($product->products_json)
            ? $product->products_json
            : json_decode($product->products_json, true))
        : [];
    // dd($productsjson);
@endphp

<table class="table table-bordered" id="productTable">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Warranty</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productsjson as $index => $item)
            <tr>
                <td>
                    <select name="product_name[{{ $index }}]" class="form-control product_name_selectply">
                        <option value="">Select Product</option>
                        @foreach ($productTypes as $type)
                            <option value="{{ $type['type'] }}"
                                {{ isset($item['product_name']) && trim($item['product_name']) === trim($type['type']) ? 'selected' : '' }}
                                data-warranty="{{ $type['warranty'] }}">
                                {{ $type['type'] }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[{{ $index }}]" class="form-control product_qty"
                        value="{{ $item['quantity'] ?? 1 }}">
                </td>
                <td>
                    <input type="text" name="warranty_years[{{ $index }}]" class="form-control warranty_years"
                        value="{{ $item['warranty_years'] ?? '' }}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeRow">X</button>
                </td>
            </tr>
        @empty
            {{-- If no saved products, show one empty row --}}
            <tr>
                <td>
                    <select name="product_name[0]" class="form-control product_name_selectply">
                        <option value="">Select Product</option>
                        @foreach ($productTypes as $type)
                            <option value="{{ $type['type'] }}" data-warranty="{{ $type['warranty'] }}">
                                {{ $type['type'] }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="quantity[0]" class="form-control product_qty" value="1"></td>
                <td><input type="text" name="warranty_years[0]" class="form-control warranty_years" readonly></td>
                <td><button type="button" class="btn btn-danger removeRow">X</button></td>
            </tr>
        @endforelse
    </tbody>
</table>


<button type="button" class="btn btn-success" id="addRow">+ Add More</button>
{{-- <button type="button" class="btn btn-primary" id="getJson">Get JSON</button>

 <pre id="output"></pre> --}}
