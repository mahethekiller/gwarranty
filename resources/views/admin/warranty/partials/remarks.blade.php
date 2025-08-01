<div class="card">
    <div class="card-header">
        <h4>Logs for Warranty #{{ $warranty->id }}</h4>
    </div>
    <div class="card-body" style="max-height: 500px; overflow-y: scroll;">


        @forelse($warranty->logs as $log)
            <div class="log-entry mb-3 p-2 bg-light border rounded">
                <p>
                    <strong>{{ optional($log->user)->name ?? 'System' }}</strong>
                    updated the <strong>{{ $log->field }}</strong>
                    from <em>"{{ $log->old_value }}"</em> to <em>"{{ $log->new_value }}"</em>
                    on <strong>{{ $log->created_at->format('d M Y, h:i A') }}</strong>.
                </p>
            </div>
        @empty
            <p class="text-muted">No logs available for this warranty.</p>
        @endforelse
    </div>
</div>
