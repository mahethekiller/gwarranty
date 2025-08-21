 {{-- <div class="col-md-6">
     <label class="form-label">Product Name</label>
     @php
         $types = $product->product->product_types ? json_decode($product->product->product_types, true) : [];

         $filteredTypes = array_filter($types, function ($type) use ($product) {
             return isset($type['usage']) && $type['usage'] === $product->application_type;
         });
     @endphp

     <select class="form-control product_name_selectmfloor" name="product_name[{{ $index }}]">
         <option value="">Select Product Type</option>
         @foreach ($filteredTypes as $type)
             <option value="{{ $type['type'] }}" data-warranty="{{ $type['warranty'] }}"
                 {{ $product->product_name == $type['type'] ? 'selected' : '' }}>
                 {{ $type['type'] }}
             </option>
         @endforeach
     </select>
 </div>
 <input type="hidden" name="warranty_years[{{ $index }}]" class="warranty_hidden"
     value="{{ $product->warranty_years ?? '' }}"> --}}

 @php
     $types = $product->product->product_types ? json_decode($product->product->product_types, true) : [];

     $filteredTypes = array_filter($types, function ($type) use ($product) {
         return isset($type['usage']) && $type['usage'] === $product->application_type;
     });

     $productsjsonFloor = !empty($product->products_jsonFloor)
         ? (is_array($product->products_jsonFloor)
             ? $product->products_jsonFloor
             : json_decode($product->products_jsonFloor, true))
         : [];
 @endphp


 <script>
     var productTypesFloor = @json(array_values($filteredTypes ?? []));
 </script>

 <table class="table table-bordered" id="productTableFloor">
     <thead>
         <tr>
             <th>Product Name</th>
             <th>Quantity</th>
             <th>Warranty (Years)</th>
             <th>Action</th>
         </tr>
     </thead>
     <tbody>
         @forelse($productsjsonFloor as $index => $item)
             <tr>
                 <td>
                     <select name="product_name_floor[{{ $index }}]"
                         class="form-control product_name_selectmfloor">
                         <option value="">Select Product Type</option>
                         @foreach ($filteredTypes as $type)
                             <option value="{{ $type['type'] }}"
                                 {{ isset($item['product_name']) && trim($item['product_name']) === trim($type['type']) ? 'selected' : '' }}
                                 data-warranty="{{ $type['warranty'] }}">
                                 {{ $type['type'] }}
                             </option>
                         @endforeach
                     </select>
                 </td>
                 <td>
                     <input type="number" name="quantity_floor[{{ $index }}]" class="form-control product_qty"
                         value="{{ $item['quantity'] ?? 1 }}" min="1">
                 </td>
                 <td>
                     <input type="text" name="warranty_years_floor[{{ $index }}]"
                         class="form-control warranty_years" value="{{ $item['warranty_years'] ?? '' }}" readonly>
                 </td>
                 <td>
                     <button type="button" class="btn btn-danger removeRow">X</button>
                 </td>
             </tr>
         @empty
             {{-- Default empty row if no saved products --}}
             <tr>
                 <td>
                     <select class="form-control product_name_selectmfloor">
                         <option value="">Select Product Type</option>
                         @foreach ($filteredTypes as $type)
                             <option value="{{ $type['type'] }}" data-warranty="{{ $type['warranty'] }}">
                                 {{ $type['type'] }}
                             </option>
                         @endforeach
                     </select>
                 </td>
                 <td><input type="number" class="form-control product_qty" value="1" min="1"></td>
                 <td><input type="text" class="form-control warranty_years" readonly></td>
                 <td><button type="button" class="btn btn-danger removeRow">X</button></td>
             </tr>
         @endforelse
     </tbody>
 </table>

 <button type="button" class="btn btn-success" id="addRowFloor">+ Add More</button>


 {{-- <button type="button" class="btn btn-primary" id="getJsonFloor">Get JSON</button>

 <pre id="outputFloor"></pre> --}}
