@if ($products->count() > 0)
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->product->name ?? 'N/A' }}</td>
            <td>
                <span
                    class="badge rounded-pill
                    @if ($product->branch_admin_status === 'modify') bg-danger
                    @elseif($product->branch_admin_status === 'approved' && $product->country_admin_status === 'approved') bg-success
                    @else bg-warning @endif text-white">
                    @if ($product->branch_admin_status === 'modify')
                        MODIFY
                    @elseif($product->branch_admin_status === 'approved' && $product->country_admin_status === 'approved')
                        APPROVED
                    @else
                        PENDING
                    @endif
                </span>
            </td>
            <td>
                @if (
                    $product->product_type == 1 &&
                        $product->branch_admin_status === 'approved' &&
                        $product->country_admin_status === 'approved')
                    @php
                        $productsjsonFloor = !empty($product->products_jsonFloor)
                            ? (is_array($product->products_jsonFloor)
                                ? $product->products_jsonFloor
                                : json_decode($product->products_jsonFloor, true))
                            : [];
                    @endphp

                    @if (!empty($productsjsonFloor))
                        @foreach ($productsjsonFloor as $index => $prod)
                            <a href="{{ route('user.warranty.certificates.download', $product->id) }}{{ isset($prod['product_name']) ? '?product=' . urlencode($prod['product_name']) : '' }}"
                                target="_blank" class="download-icon-red">
                                <i class="fa fa-download"></i>&nbsp;Download {{ $prod['product_name'] ?? 'Product' }}
                            </a>
                        @endforeach
                    @endif
                @elseif(
                    $product->product_type == 2 &&
                        ($product->branch_admin_status === 'approved' && $product->country_admin_status === 'approved'))
                    {{-- door --}}
                    <a href="{{ url('/user/warranty/certificate/download/' . $product->id) }}" target="_blank"
                        class="download-icon-red">
                        <i class="fa fa-download"></i>&nbsp;Download
                    </a>
                @elseif(
                    $product->product_type == 3 &&
                        ($product->branch_admin_status === 'approved' && $product->country_admin_status === 'approved'))
                    @php
                        $productsjson = !empty($product->products_json)
                            ? (is_array($product->products_json)
                                ? $product->products_json
                                : json_decode($product->products_json, true))
                            : [];
                    @endphp

                    @if (!empty($productsjson))
                        @foreach ($productsjson as $prod)
                            <a href="{{ url('/user/warranty/certificate/download/' . $product->id) }}{{ !empty($prod['product_name']) ? '?product=' . urlencode($prod['product_name']) : '' }}"
                                target="_blank" class="download-icon-red">
                                <i class="fa fa-download"></i>&nbsp;Download {{ $prod['product_name'] ?? 'Product' }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ url('/user/warranty/certificate/download/' . $product->id) }}" target="_blank"
                            class="download-icon-red">
                            <i class="fa fa-download"></i>&nbsp;Download
                        </a>
                    @endif
                @elseif ($product->branch_admin_status === 'approved' && $product->country_admin_status === 'approved')
                    <a href="{{ url('/user/warranty/certificate/download/' . $product->id) }}" target="_blank"
                        class="download-icon-red">
                        <i class="fa fa-download"></i>&nbsp;Download
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="4" class="text-center">No Products Found</td>
    </tr>
@endif
