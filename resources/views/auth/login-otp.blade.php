<x-common-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">







        <div class="row align-items-center form-login-bg">
            <div class="col-md-12 col-lg-12">
                <form class="signin-left" id="login-form" action="{{ route('login.send.otp') }}" method="POST">
                    <h1 class="h3 mb-3">Sign In</h1>
                    <h2>If you have already registered at our Warranty Services Portal for Consumers, please sign in
                        here.</h2>

                    @csrf
                    <div class="form-group">




                        <label for="phone">Phone Number*</label>
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
                  <div class="signin-left">
                        <form id="login-verify-form" action="{{ route('login.verify.otp') }}" method="POST">
                        <h1>Enter OTP </h1> <span id="temp_otp" class="text-info"></span>
                    <h3>A one time password(OTP) has been sent to your mobile.</h3>
                        @csrf
                       <div class="form-group">
                        <input type="text" name="otp" placeholder="Enter OTP">
                    </div>
                    <div id="login-timer"></div>
                    <span class="error" id="login-error-otp"></span><br>
                        <button type="submit" class="custom-btn2">Verify</button>
                        <button id="login-resend-btn" class="custom-btn3" disabled>Resend OTP</button>

                    </form>
                    </div>
                </div>


            </div>



</x-common-layout>
