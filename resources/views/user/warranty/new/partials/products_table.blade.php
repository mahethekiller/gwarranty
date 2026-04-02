@if(count($products) == 0)
    <tr>
        <td colspan="4" class="text-center">No products found.</td>
    </tr>
@else
    @foreach($products as $product)
    <tr>
        <td>{{ $product->serial_number ?: 'N/A' }}</td>
        <td>
            {{ $product->productType->name }}
            @php
                $variantDisp = $product->variant ?: ($product->productTypeVariant->variant_name ?? null);
                $usageType = $product->productTypeVariant->usage_type ?? null;
            @endphp
            @if($variantDisp)
                <br><small class="text-muted">{{ $variantDisp }}
                    @if($usageType)
                        ({{ $usageType }})
                    @endif
                </small>
            @endif
        </td>
        <td>
            @if($product->status === 'approved')
                <span class="badge bg-success">APPROVED</span>
            @elseif($product->status === 'pending')
                <span class="badge bg-warning text-dark">PENDING</span>
            @elseif($product->status === 'rejected')
                <span class="badge bg-danger">REJECTED</span>
            @elseif($product->status === 'modify')
                <span class="badge bg-info text-white">MODIFY</span>
            @else
                <span class="badge bg-secondary">{{ strtoupper($product->status) }}</span>
            @endif
        </td>
        <td>
            @if($product->status === 'approved')
                <a href="{{ route('user.warranty.certificate.download', $product->id) }}" target="_blank" class="btn btn-sm btn-success">
                    <i class="fa fa-download me-1"></i> Download
                </a>
            @else
                <span class="text-muted small">Not Available</span>
            @endif
        </td>
    </tr>
    @endforeach
@endif
