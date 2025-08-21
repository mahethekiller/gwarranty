<table class="table table-bordered ">
    <thead>
        <tr>
            <th colspan="6">Product Types</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($warrantyProducts as $index => $product)
            <tr>
                <td colspan="6">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $product->product->name }}

                            @if (auth()->user()->hasRole('country_admin'))
                                <small
                                    class="badge rounded-pill status-badge bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Status: {{ ucfirst($product->country_admin_status) }}
                                </small>

                                <small
                                    class=" badge rounded-pill  bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">Branch
                                    admin status: {{ $product->branch_admin_status }}</small>
                            @endif

                            @if (auth()->user()->hasRole('branch_admin'))
                                <small
                                    class="badge rounded-pill status-badge bg-{{ $product->branch_admin_status == 'pending' ? 'warning' : ($product->branch_admin_status == 'modify' ? 'info' : 'success') }}">
                                    Status: {{ ucfirst($product->branch_admin_status) }}
                                </small>
                                <small
                                    class=" badge rounded-pill  bg-{{ $product->country_admin_status == 'pending' ? 'warning' : ($product->country_admin_status == 'rejected' ? 'danger' : 'success') }}">Country
                                    admin status: {{ $product->country_admin_status }}</small>
                            @endif
                        </strong>
                        <div class="text-success save-message d-none">Updated!...</div>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRow{{ $index }}" aria-expanded="false"
                            aria-controls="collapseRow{{ $index }}">
                            View Details
                        </button>
                    </div>

                    <div class="collapse mt-3" id="collapseRow{{ $index }}">
                        <div class="card card-body">

                            {{-- Existing fields --}}
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Qty
                                            Purchased:</strong></label>
                                    <p>{{ $product->qty_purchased }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Application
                                            Type:</strong></label>
                                    <p>{{ $product->application_type ?: 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label">Total Quantity</label>
                                    <input type="number" class="form-control total_quantity"
                                        value="{{ $product->total_quantity }}" />
                                </div>

                                @if (auth()->user()->hasRole('branch_admin'))
                                    <div class="col-md-6">
                                        <label class="form-label">Product Status </label>
                                        <select class="form-control branch_admin_status">
                                            <option value="pending"
                                                {{ $product->branch_admin_status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="modify"
                                                {{ $product->branch_admin_status == 'modify' ? 'selected' : '' }}>
                                                Modify</option>
                                            <option value="approved"
                                                {{ $product->branch_admin_status == 'approved' ? 'selected' : '' }}>
                                                Approved</option>
                                        </select>
                                    </div>
                                @elseif(auth()->user()->hasRole('country_admin'))
                                    <div class="col-md-6">
                                        <label class="form-label">Product Status</label>
                                        <select class="form-control country_admin_status">
                                            <option value="pending"
                                                {{ $product->country_admin_status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="modify"
                                                {{ $product->country_admin_status == 'modify' ? 'selected' : '' }}>
                                                Modify</option>
                                            <option value="approved"
                                                {{ $product->country_admin_status == 'approved' ? 'selected' : '' }}>
                                                Approved</option>
                                        </select>
                                    </div>
                                @endif
                            </div>

                            {{-- Total Quantity & Status --}}

                            <div class="row mb-2">



                                <div class="col-md-12 {{ $product->product_type == 4 ? 'd-none' : '' }}">
                                    <label class="form-label">Invoice Date</label>
                                    <input type="text" id="datepickercustom" class="form-control invoice_date"
                                        value="{{ $product->invoice_date }}">
                                </div>

                            </div>






                            {{-- New Fields --}}

                            <div class="row mb-2 {{ $product->product_type != 3 ? 'd-none' : '' }}">
                                <div class="col-md-12">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" class="form-control branch_name"
                                        value="{{ $product->branch_name }}">
                                </div>


                            </div>


                            <div class="row mb-2">
                                <div
                                    class="col-md-6 {{ $product->product_type != 5 && $product->product_type != 4 ? 'd-none' : '' }} ">
                                    <label class="form-label">Execution Agency</label>
                                    <input type="text" class="form-control execution_agency"
                                        value="{{ $product->execution_agency }}">
                                </div>
                                <div
                                    class="col-md-6 {{ $product->product_type == 4 || $product->product_type == 2 || $product->product_type == 5 ? '' : 'd-none' }} ">
                                    <label class="form-label">Handover
                                        Certificate Date
                                        <a class="download-icon-red"
                                            href="{{ asset('storage/' . $product->handover_certificate) }}"
                                            target="_blank">
                                            View Certificate
                                        </a>

                                    </label>
                                    <input type="text" id="datepicker" class="form-control handover_certificate_date"
                                        value="{{ $product->handover_certificate_date }}">
                                </div>
                            </div>

                            <div class="row mb-2 {{ $product->product_type != 1 ? 'd-none' : '' }}">
                                <div class="col-md-6">
                                    <label class="form-label">Product Code</label>
                                    <input type="text" class="form-control product_code"
                                        value="{{ $product->product_code }}">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Type of Surface Treatment</label>
                                    <input type="text" class="form-control surface_treatment_type"
                                        value="{{ $product->surface_treatment_type }}">
                                </div>
                            </div>

                            <div class="row mb-2 {{ $product->product_type != 2 ? 'd-none' : '' }}">
                                <div class="col-md-12 ">
                                    <label class="form-label">Product Thickness</label>
                                    <input type="text" class="form-control product_thickness"
                                        value="{{ $product->product_thickness }}">
                                </div>

                            </div>
                            <div class="row mb-2 {{ $product->product_type != 2 ? 'd-none' : '' }}">

                                <div class="col-md-12">
                                    <label class="form-label">Project Location</label>
                                    <input type="text" class="form-control project_location"
                                        value="{{ $product->project_location }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                @if ($product->product_type == 3)
                                    {{-- Mikasa Ply --}}
                                    @include('admin.warranty.partials.mikasaply-products')
                                @elseif ($product->product_type == 1)
                                    {{-- Mikasa Floors --}}
                                    @include('admin.warranty.partials.mikasafloor-products')
                                @elseif(in_array($product->product_type, [4, 2, 6, 5]))
                                    {{-- Common warranty types --}}
                                    @include('admin.warranty.partials.common-products')
                                @endif
                            </div>

                            <hr>
                            {{-- Remarks --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">Remarks For Customer</label>
                                    <textarea class="form-control product_remarks" placeholder="Enter Remarks">{{ $product->remarks }}</textarea>
                                </div>
                            </div>

                            {{-- Error + Success messages --}}
                            <div class="error-message text-danger mt-2 d-none"></div>
                            {{-- <div class="text-success save-message d-none">Saved!...</div> --}}



                            <div class="text-end">
                                <button type="button" class="btn btn-success btn-sm save-product-btn"
                                    data-id="{{ $product->id }}">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach



    </tbody>
</table>
