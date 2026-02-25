<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="''">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Process Warranty #{{ $warranty->id }}</h4>
                <a href="{{ route('branch.warranties.new.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">

                {{-- Warranty Details --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Dealer:</strong> {{ $warranty->dealer_name }}<br>
                        <strong>Location:</strong> {{ $warranty->dealer_city }}, {{ $warranty->dealer_state }}
                    </div>
                    <div class="col-md-4">
                        <strong>Customer:</strong> {{ $warranty->user->name ?? 'N/A' }}<br>
                        <strong>Email:</strong> {{ $warranty->user->email ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Invoice No:</strong> {{ $warranty->invoice_number }}<br>
                        <strong>Invoice Date:</strong> {{ $warranty->invoice_date ? $warranty->invoice_date->format('d M, Y') : 'N/A' }}<br>
                        @if($warranty->invoice_file_path)
                            <a href="{{ Storage::url($warranty->invoice_file_path) }}" target="_blank" class="btn btn-xs btn-info mt-1">View Invoice</a>
                        @endif
                    </div>
                </div>

                <form action="{{ route('branch.warranties.new.update', $warranty->id) }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Product Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="25%">Product Info</th>
                                    <th width="15%">Details</th>
                                    <th width="15%">Docs</th>
                                    <th width="20%">Status</th>
                                    <th width="25%">Admin Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warranty->productDetails as $index => $product)
                                <tr>
                                    <td>
                                        <strong>{{ $product->productType->name }}</strong>
                                        @if($product->variant) <br>Variant: {{ $product->variant }} @endif
                                        @if($product->product_name_design) <br>Design: {{ $product->product_name_design }} @endif
                                        @if($product->product_category) <br>Cat: {{ $product->product_category }} @endif
                                    </td>
                                    <td>
                                        @if($product->quantity) Qty: {{ $product->quantity }} {{ $product->uom }}<br> @endif
                                        @if($product->area_sqft) Area: {{ $product->area_sqft }} Sq.Ft.<br> @endif
                                        @if($product->no_of_boxes) Boxes: {{ $product->no_of_boxes }} @endif
                                    </td>
                                    <td>
                                        @if($product->handover_certificate)
                                            <a href="{{ Storage::url($product->handover_certificate) }}" target="_blank" class="btn btn-xs btn-info mb-1">Handover Cert.</a>
                                        @endif
                                        @if($product->invoice_number)
                                        <br><small>Inv: {{ $product->invoice_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                        <select class="form-select form-select-sm" name="products[{{ $index }}][status]">
                                            <option value="pending" {{ $product->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $product->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="modify" {{ $product->status === 'modify' ? 'selected' : '' }}>Modify Required</option>
                                            <option value="rejected" {{ $product->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea class="form-control form-control-sm" name="products[{{ $index }}][admin_remarks]" rows="2" placeholder="Remarks for customer...">{{ $product->admin_remarks }}</textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-userdashboard-layout>
