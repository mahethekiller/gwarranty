<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form  id="profileForm" action="{{ route('user.profile.update') }}" method="POST">
                      @csrf
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="name" class="form-label custom-form-label">Name</label>
                                <input class="form-control" id="name" name="name" type="text" value="{{ Auth::user()->name }}" placeholder="Enter Your Name">
                                <span class="text-danger" id="error-name"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="email" class="form-label custom-form-label">Email Id</label>
                                <input class="form-control" id="email" name="email" type="email" value="{{ Auth::user()->email }}" placeholder="Enter Email Id">
                                <span class="text-danger" id="error-email"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="phone_number" class="form-label custom-form-label">Phone Number</label>
                                <input class="form-control" id="phone_number" value="{{ Auth::user()->phone_number }}" type="text"
                                    placeholder="+91-88990 02244" disabled>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="city" class="form-label custom-form-label">City</label>
                                <input class="form-control" id="city" name="city" value="{{ Auth::user()->city }}" type="text" placeholder="Enter City">
                                <span class="text-danger" id="error-city"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="state" class="form-label custom-form-label">State</label>
                                <input class="form-control" id="state" name="state" value="{{ Auth::user()->state }}" type="text" placeholder="Enter State">
                                <span class="text-danger" id="error-state"></span>
                            </div>
                        </div>

<div class="col-lg-4">
                            <div class="form-group">
                                <label for="pincode" class="form-label custom-form-label">Pincode</label>
                                <input class="form-control" id="pincode" value="{{ Auth::user()->pincode }}" name="pincode" type="text" placeholder="Enter Pincode">
                                <span class="text-danger" id="error-pincode"></span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="address" class="form-label custom-form-label">Address</label>
                                <input class="form-control" id="address" name="address" value="{{ Auth::user()->address }}" type="text" placeholder="Enter Address">
                                <span class="text-danger" id="error-address"></span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <button class="custom-btn-blk" type="submit">Save Profile</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-userdashboard-layout>
