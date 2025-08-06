<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>Warranty Details</h3>
                    {{-- {{ dd($warrantyProduct) }} --}}
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Product Name:</strong> {{$warrantyProduct->product->name}}</p>
                            <p><strong>Product Type:</strong> {{$warrantyProduct->product->type}}</p>
                            <p><strong>Purchase Date:</strong> {{$warrantyProduct->purchase_date}}</p>
                            <p><strong>Invoice Number:</strong> {{$warrantyProduct->invoice_number}}</p>
                            <p><strong>Serial Number:</strong> {{$warrantyProduct->serial_number}}</p>
                            <p><strong>Warranty Period:</strong> {{$warrantyProduct->warranty_period}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Application Type:</strong> {{$warrantyProduct->application_type}}</p>
                            <p><strong>Handover Certificate:</strong>
                                @if($warrantyProduct->handover_certificate)
                                    <a href="{{asset('storage/' . $warrantyProduct->handover_certificate)}}" target="_blank">View</a>
                                @else
                                    Not Available
                                @endif
                            </p>
                            <p><strong>Remarks:</strong> {{$warrantyProduct->remarks}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-userdashboard-layout>
