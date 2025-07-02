<x-common-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="phone_number" placeholder="Enter your phone number" required>
        <button type="submit">Send OTP</button>
    </form> --}}



    <div class="row align-items-center form-login-bg">
        <div class="col-md-12 col-lg-12">
            <form class="signin-left" id="registerForm" method="POST" action="{{ route('registerotp') }}">
                @csrf
                <h1 class="h3 mb-3">Sign Up</h1>
                <h2>Kindly register for Greenlam warranty self service portal with Mobile Number Verification.
                </h2>
                {{-- <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul> --}}
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Your Name*"
                                name="name">

                            <span class="error-text text-danger" id="name-error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="emailid">Email Id*</label>
                            <input type="email" class="form-control" id="emailid" name="email"
                                placeholder="Enter Your Email Id*">
                            <span class="error-text text-danger" id="email-error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Address*</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Enter Your Address*">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="phonenumber">Phone Number*</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Enter Your Phone Number*">
                            <span class="error-text text-danger" id="phone_number-error"></span>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div class="form-group">
                            <button class="w-100 btn btn-lg btn-primary custom-btn-signin" type="submit">Get
                                OTP</button>
                        </div>
                        <p>By providing my phone number, I hereby agree and accept the <a href="#">Terms of
                                Service</a> and <a href="#">Privacy Policy</a> in use of the Warranty Services
                            Portal.</p>
                    </div>
                </div>


            </form>
            <!-- OTP Verification Form -->
            <div class="signin-left " id="verifyOtpFormDiv" style="display: none;">

                <form id="verifyOtpForm" >
                    <h1>Enter OTP</h1><span id="temp_otp" class="text-info"></span>
                    <h3>A one time password(OTP) has been sent to your mobile.</h3>
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
                        <span class="error-text" id="otp-error"></span>
                    </div>
                    <!-- Countdown Timer -->
                    <p id="countdown-timer"></p>
                    <!-- Success & Error Messages -->
                    <p id="success-message"></p>
                    <p id="error-message"></p>
                    <button type="submit" class="custom-btn3" id="verify-button">Verify
                        OTP</button>
                    <button type="button" class="custom-btn2" id="resendOtp" disabled>Resend OTP</button>
                </form>
            </div>
        </div>



</x-common-layout>
