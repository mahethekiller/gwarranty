<div class="card">
    <div class="card-header">
        Remarks History
    </div>
    <div class="card-body">
        @foreach ($remarks as $remark)
            <li>
                <strong>{{ $remark->created_at->format('d M Y, h:i A') }}</strong>:
                {{ $remark->remark }}
                @if ($remark->user)
                    <em> - by {{ $remark->user->name }}</em>
                @endif
            </li>
        @endforeach
    </div>
</div>
