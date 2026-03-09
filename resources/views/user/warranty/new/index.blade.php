<x-userdashboard-layout :pageTitle="'My Warranties'" :pageDescription="'View and manage your warranty registrations'">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Warranty Registrations</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Dealer Name</th>
                                    <th>Date Submitted</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Admin Remarks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warranties as $warranty)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $warranty->invoice_number }}</td>
                                        <td>{{ $warranty->invoice_date ? $warranty->invoice_date->format('d M, Y') : 'N/A' }}</td>
                                        <td>{{ $warranty->dealer_name }}</td>
                                        <td>{{ $warranty->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @foreach($warranty->productDetails as $product)
                                                <span class="badge bg-info me-1">
                                                    {{ $product->productType->name }} ({{ $product->quantity ?? 'N/A' }})
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($warranty->overall_status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($warranty->overall_status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($warranty->overall_status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @elseif($warranty->overall_status === 'modify')
                                                <span class="badge bg-primary">Modify Required</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($warranty->admin_remarks)
                                                <small>{{ Str::limit($warranty->admin_remarks, 50) }}</small>
                                            @else
                                                @php
                                                    $productRemarks = $warranty->productDetails->filter(function($p) { return !empty($p->admin_remarks); })->pluck('admin_remarks');
                                                @endphp
                                                @if($productRemarks->isNotEmpty())
                                                    <small class="text-danger" title="{{ $productRemarks->implode(', ') }}">
                                                        {{ Str::limit($productRemarks->first(), 50) }}
                                                        @if($productRemarks->count() > 1)
                                                            <br><span class="text-muted">(+{{ $productRemarks->count() - 1 }} more)</span>
                                                        @endif
                                                    </small>
                                                @else
                                                    <span class="text-muted">No remarks</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('user.warranty.show', $warranty->id) }}"
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if($warranty->overall_status === 'modify')
                                                    <a href="{{ route('user.warranty.new.edit', $warranty->id) }}"
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No warranty registrations found.
                                            <a href="{{ route('user.warranty.new.create') }}" class="ms-2">
                                                Register a new warranty
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($warranties->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $warranties->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-userdashboard-layout>
