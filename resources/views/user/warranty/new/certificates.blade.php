<x-userdashboard-layout :pageTitle="'Download Certificates (New)'" :pageDescription="'Download warranty certificates for your new registrations'">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Warranty Certificates (New System)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="newWarrantyCertTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Dealer</th>
                                    <th>Dealer State & City</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warranties as $warranty)
                                    <tr>
                                        <td>{{ $warranty->created_at->format('d-M-Y') }}</td>
                                        <td>{{ $warranty->dealer_name }}</td>
                                        <td>{{ $warranty->dealer_state }} > {{ $warranty->dealer_city }}</td>
                                        <td>{{ $warranty->invoice_number }}</td>
                                        <td>
                                            @if($warranty->invoice_file_path)
                                                <a href="{{ Storage::url($warranty->invoice_file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                    <i class="fa fa-eye me-1"></i> View
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary view-products-new-system"
                                               data-id="{{ $warranty->id }}"
                                               data-title="Products for Warranty #{{ $warranty->invoice_number }}">
                                                <i class="fa fa-list me-1"></i> View Products
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No approved warranty registrations found in the new system.</td>
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

    <!-- Products Modal -->
    <div class="modal fade" id="newProductsModal" tabindex="-1" aria-labelledby="newProductsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newProductsModalLabel">Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="newProductsModalBody">
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-products-new-system', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const title = $(this).data('title');

                $('#newProductsModalLabel').text(title);
                $('#newProductsModalBody').html('<tr><td colspan="3" class="text-center"><i class="fa fa-spinner fa-spin me-2"></i>Loading products...</td></tr>');
                $('#newProductsModal').modal('show');

                $.ajax({
                    url: "{{ route('user.warranties.products-ajax', '') }}/" + id,
                    method: 'GET',
                    success: function(response) {
                        $('#newProductsModalBody').html(response.html);
                    },
                    error: function() {
                        $('#newProductsModalBody').html('<tr><td colspan="3" class="text-center text-danger">Failed to load products.</td></tr>');
                    }
                });
            });
        });
    </script>
    @endpush
</x-userdashboard-layout>
