<x-common-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">






    <main class="form-signin text-center my-5">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-6">
                <form class="signin-left" id="login-form" action="{{ route('login.send.otp') }}" method="POST">
                    <h1 class="h3 mb-3 fw-normal">Sign In</h1>
                    <h2>If you have already registered at our Warranty Services Portal for Consumers, please sign in
                        here.</h2>

                    @csrf
                    <div class="form-group">




                        <label for="phone">Phone*</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            placeholder="Enter Your Phone Number*" required>
                        {{-- <input type="text" name="phone_number" id="login-phone" placeholder="Phone"> --}}
                        <span class="error" id="login-error-phone_number"></span><br>
                        {{-- <button type="submit">Send OTP</button> --}}


                    </div>
                    <button class="w-100 btn btn-lg btn-primary custom-btn-signin" type="submit">Get OTP</button>
                    <p>By providing my phone number, I hereby agree and accept the <a href="#">Terms of
                            Service</a> and <a href="#">Privacy Policy</a> in use of the Warranty Services Portal.
                    </p>



                </form>

                <div id="login-otp-section" style="display:none;">
                    <form id="login-verify-form" action="{{ route('login.verify.otp') }}" method="POST">
                        @csrf
                        <input type="text" name="otp" placeholder="Enter OTP">
                        <span class="error" id="login-error-otp"></span><br>
                        <button type="submit">Verify</button>
                    </form>
                    <button id="login-resend-btn" disabled>Resend OTP</button>
                    <div id="login-timer"></div>
                </div>


            </div>
            <div class="col-md-6 col-lg-6 signin-right">
                <img src="images/sign-in-img.jpg" class="img-fluid"
                    alt="Greenlam Industries - Warranty Services Portal for Consumers" />
            </div>
    </main>


</x-common-layout>
