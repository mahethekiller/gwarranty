<div class="card">
    <div class="card-header">
        <h4>Update Status </h4>
    </div>
    <div class="card-body">

        {{-- {{ dd($warrantyProducts[0]) }} --}}


        <form action="{{ route('updatecountryadminstatus', $warrantyProducts[0]->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">

                {{-- {{ dd($warranty) }} --}}


                <div class="col-md-12">
                    <label for="country_admin_status" class="col-md-4 col-form-label text-md-right">Status</label>
                    <select class="form-control" id="country_admin_status" name="country_admin_status">
                        <option value="approved"
                            {{ old('country_admin_status', $warrantyProducts[0]->country_admin_status) == 'approved' ? 'selected' : '' }}>
                            Approved</option>
                        <option value="rejected"
                            {{ old('country_admin_status', $warrantyProducts[0]->country_admin_status) == 'rejected' ? 'selected' : '' }}>
                            Rejected</option>
                        <option value="pending"
                            {{ old('country_admin_status', $warrantyProducts[0]->country_admin_status) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group row">


                <div class="col-md-12">
                    <label for="remarks" class="col-md-4 col-form-label text-md-right">Remarks</label>
                    <textarea class="form-control" id="country_admin_remarks" name="country_admin_remarks" rows="3"></textarea>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="form-group row mb-0">
                <div class="col-md-12 ">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

    </div>
</div>
