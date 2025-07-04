<?php
namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {

        return view('auth.registerotp', [
            'pageTitle'       => 'Register',
            'pageDescription' => 'Register for Greenlam Industries warranty self service portal with Mobile Number Verification.',
            'pageScript'      => "auth",
        ]);
    }

    public function showLoginForm()
    {

        return view('auth.login-otp', [
            'pageTitle'       => 'Login',
            'pageDescription' => 'Login for Greenlam Industries warranty self service portal with Mobile Number Verification.',
            'pageScript'      => "login",
        ]);
    }

    // Send OTP for registration
    public function sendOtpForRegistration(Request $request)
    {
        // echo "hi";
        // exit;
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|digits:10|unique:users,phone_number',
            // 'address'      => 'required|string|max:500',
        ]);

        $otp       = rand(100000, 999999); // Generate 6-digit OTP
        $expiresAt = Carbon::now()->addMinutes(5);

        // Store OTP in database
        Otp::updateOrCreate(
            ['phone_number' => $request->phone_number],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Send OTP via Twilio SMS
        // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        // $twilio->messages->create(
        //     $request->phone_number,
        //     [
        //         'from' => env('TWILIO_PHONE_NUMBER'),
        //         'body' => "Your OTP is: $otp",
        //     ]
        // );

        // Store the data temporarily in the session
        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your phone successfully!',
            'otp'     => $otp,
        ]);
    }

    public function sendLoginOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);

        $otp       = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        session(['login_phone_number' => $request->phone_number]);

        Otp::updateOrCreate(
            ['phone_number' => $request->phone_number],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        return response()->json(['success' => true, 'message' => 'OTP sent for login', 'otp' => $otp]);
    }

    // Show OTP verification form
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Verify OTP and create user
    public function verifyOtp(Request $request)
    {
        // Validate the OTP
        $otpRecord = Otp::where('phone_number', $request->phone_number)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();


        if ($otpRecord) {
            // If OTP is correct, create or fetch the user
            $user = User::firstOrCreate(
                ['phone_number' => $request->phone_number],
                [
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone_number' => $request->phone_number,
                    'address'      => $request->address,
                    'password'     => bcrypt('default_password'), // Set a default password, you can update this later
                ]
            );
            $user->assignRole('user');

            $user->assignRole('user');
            // Log the user in
            Auth::login($user);

            // Delete the OTP record to prevent reuse
            $otpRecord->delete();

            // Redirect response
            return response()->json([
                'success'      => true,
                'message'      => 'OTP verified successfully! Redirecting to your dashboard...',
                'redirect_url' => route('dashboard'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.',
            ]);
        }
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $phone = session('login_phone_number');
        $otp   = Otp::where('phone_number', $phone)->first();

        if (! $otp || $otp->otp !== $request->otp || now()->gt($otp->expires_at)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 422);
        }

        $user = User::where('phone_number', $phone)->first();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        Auth::login($user);

        session()->forget('login_phone_number');
        $otp->delete();

        if ($user->hasRole('admin')) {
            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        if ($user->hasRole('editor')) {
            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }

    // Resend OTP Logic
    public function resendOtp(Request $request)
    {
        $otp       = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        Otp::updateOrCreate(
            ['phone_number' => $request->phone_number],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Optional: Send OTP again via SMS gateway

        return response()->json([
            'success' => true,
            'message' => 'OTP resent successfully! You have 5 more minutes.',
        ]);
    }
}
