<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> {{ $warranty->dealer_name }}</li>
    <li class="list-group-item"><strong>City:</strong> {{ $warranty->dealer_city }}</li>
    <li class="list-group-item"><strong>Invoice Number:</strong> {{ $warranty->invoice_number }}</li>
    <li class="list-group-item">
        <strong>Invoice File:</strong>
        @if ($warranty->upload_invoice)
            <a href="/storage/{{ $warranty->upload_invoice }}" target="_blank" class="download-icon-red">
                <i class="fa fa-download"></i>&nbsp;View
            </a>
        @endif
    </li>
    <li class="list-group-item d-none">
        <input type="hidden" name="created_at" id="created_at" value="{{ $warranty->created_at->format('Y-m-d') }}">
    </li>

</ul>
