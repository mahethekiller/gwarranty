<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="''">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Branch Warranty Management</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="warrantyTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dealer</th>
                                <th>Invoice Details</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($warranties as $warranty)
                            <tr>
                                <td>{{ $warranty->id }}</td>
                                <td>
                                    {{ $warranty->dealer_name }}<br>
                                    <small>{{ $warranty->user->name ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $warranty->invoice_number }}<br>
                                    <small class="text-muted">{{ $warranty->invoice_date ? $warranty->invoice_date->format('d M Y') : 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $warranty->dealer_city }}, {{ $warranty->dealer_state }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($warranty->overall_status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'modify' => 'bg-warning',
                                            default => 'bg-primary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($warranty->overall_status) }}
                                    </span>
                                </td>
                                <td>{{ $warranty->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('branch.warranties.new.edit', $warranty->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i> Process
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No warranties found for your branch.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $warranties->links() }}
                </div>
            </div>
        </div>
    </div>
</x-userdashboard-layout>
