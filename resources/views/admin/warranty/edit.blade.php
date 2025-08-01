<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="col-md-8 col-xl-8">
        <div class="card">
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-lg-6">
                        <h4 class="card-title">Customer Details</H4>
                        @include('admin.warranty.partials.customer_details')
                    </div>
                    <div class="col-lg-6">
                        <h4 class="card-title">Dealer Details</H4>
                        @include('admin.warranty.partials.dealer_details')
                    </div>
                </div>




                {{-- <input type="hidden" name="warranty_id" id="warranty_id" value="{{ $warranty->id }}" /> --}}

                {{-- {{ dd($warrantyProducts) }} --}}

                <div class="form-group row">

                    <div class="col-lg-12">

                        @if (auth()->user()->hasRole('country_admin'))
                            @include('admin.warranty.partials.country_admin_edit')
                        @elseif(auth()->user()->hasRole('branch_admin'))
                            @include('admin.warranty.partials.branch_admin_edit')
                        @endif

                    </div>
                </div>





            </div>
        </div>

    </div>
    <div class="col-md-4 col-xl-4">

        <div class="row">
            @if (auth()->user()->hasRole('country_admin'))
                @include('admin.warranty.partials.country_admin_status_form')
            @endif
        </div>
        <div class="row">
            @include('admin.warranty.partials.remarks')
        </div>

    </div>

</x-userdashboard-layout>
