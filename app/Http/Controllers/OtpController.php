<?php
namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Helpers\OTPHelper;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

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
    // public function sendOtpForRegistration(Request $request)
    // {
    //     // echo "hi";
    //     // exit;
    //     $request->validate([
    //         // 'name'         => 'required|string|max:255',
    //         // 'email'        => 'required|email|unique:users,email',
    //         'phone_number' => 'required|digits:10|unique:users,phone_number',
    //         // 'address'      => 'required|string|max:500',
    //     ]);

    //     $otp       = rand(100000, 999999); // Generate 6-digit OTP
    //     $expiresAt = Carbon::now()->addMinutes(5);

    //     // Store OTP in database
    //     Otp::updateOrCreate(
    //         ['phone_number' => $request->phone_number],
    //         ['otp' => $otp, 'expires_at' => $expiresAt]
    //     );

    //     // Send OTP via Twilio SMS
    //     // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    //     // $twilio->messages->create(
    //     //     $request->phone_number,
    //     //     [
    //     //         'from' => env('TWILIO_PHONE_NUMBER'),
    //     //         'body' => "Your OTP is: $otp",
    //     //     ]
    //     // );

    //     // Store the data temporarily in the session
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'OTP sent to your phone successfully!',
    //         'otp'     => $otp,
    //     ]);
    // }

    public function sendOtpForRegistration(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|digits:10|unique:users,phone_number',
        ]);

        return OTPHelper::sendOTP($request->phone_number);
    }

    // public function sendLoginOtp(Request $request)
    // {
    //     $request->validate([
    //         'phone_number' => 'required|exists:users,phone_number',
    //     ]);

    //     $otp       = rand(100000, 999999);
    //     $expiresAt = now()->addMinutes(5);

    //     session(['login_phone_number' => $request->phone_number]);

    //     Otp::updateOrCreate(
    //         ['phone_number' => $request->phone_number],
    //         ['otp' => $otp, 'expires_at' => $expiresAt]
    //     );

    //     return response()->json(['success' => true, 'message' => 'OTP sent for login', 'otp' => $otp]);
    // }

    public function sendLoginOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);
        session(['login_phone_number' => $request->phone_number]);

        return OTPHelper::sendOTP($request->phone_number);
    }

    // Show OTP verification form
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Verify OTP and create user
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|digits:10',
            'otp'          => 'required|digits:6',
            'name'         => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:users,email',
            'address'      => 'nullable|string|max:500',
        ]);

        // Check OTP record
        $otpRecord = Otp::where('phone_number', $request->phone_number)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otpRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.',
            ], 422);
        }

        // Create or fetch user
        $user = User::firstOrCreate(
            ['phone_number' => $request->phone_number],
            [
                'name'     => $request->name,
                'email'    => $request->email,
                'address'  => $request->address,
                'password' => Hash::make('default_password'), // set default password
            ]
        );

        // Assign role only once
        if (! $user->hasRole('user')) {
            $user->assignRole('user');
        }

        // Login user
        Auth::login($user);

        // Delete OTP to prevent reuse
        $otpRecord->delete();

        return response()->json([
            'success'      => true,
            'message'      => 'OTP verified successfully! Redirecting...',
            'redirect_url' => $user->profile_updated ? route('dashboard') : route('profile.edit'),
        ]);
    }

    // public function verifyLoginOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required|digits:6',
    //     ]);

    //     $phone = session('login_phone_number');
    //     $otp   = Otp::where('phone_number', $phone)->first();

    //     if (! $otp || $otp->otp !== $request->otp || now()->gt($otp->expires_at)) {
    //         return response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 422);
    //     }

    //     $user = User::where('phone_number', $phone)->first();

    //     if (! $user) {
    //         return response()->json(['success' => false, 'message' => 'User not found'], 404);
    //     }

    //     Auth::login($user);

    //     session()->forget('login_phone_number');
    //     $otp->delete();

    //     if ($user->hasRole('admin')) {
    //         return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
    //     }

    //     if ($user->hasRole('branch_admin')) {
    //         return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
    //     }

    //     // return response()->json(['success' => true, 'redirect' => route('dashboard')]);

    //     return response()->json([
    //         'success'  => true,
    //         'message'  => 'OTP verified successfully! Redirecting...',
    //         'redirect' => $user->profile_updated ? route('dashboard') : route('profile.edit'),
    //     ]);
    // }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $phone = session('login_phone_number');
        if (! $phone) {
            return response()->json(['success' => false, 'message' => 'No phone number found in session'], 400);
        }

        $otpRecord = Otp::where('phone_number', $phone)->first();

        if (! $otpRecord || $otpRecord->otp !== $request->otp || now()->gt($otpRecord->expires_at)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 422);
        }

        $user = User::where('phone_number', $phone)->first();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        Auth::login($user);
        $otpRecord->delete();
        session()->forget('login_phone_number');

        if ($user->hasRole('admin') || $user->hasRole('branch_admin')) {
            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'OTP verified successfully! Redirecting...',
            'redirect' => $user->profile_updated ? route('dashboard') : route('profile.edit'),
        ]);
    }

    // Resend OTP Logic
    // public function resendOtp(Request $request)
    // {
    //     $otp       = rand(100000, 999999);
    //     $expiresAt = now()->addMinutes(5);

    //     Otp::updateOrCreate(
    //         ['phone_number' => $request->phone_number],
    //         ['otp' => $otp, 'expires_at' => $expiresAt]
    //     );

    //     // Optional: Send OTP again via SMS gateway

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'OTP resent successfully! You have 5 more minutes.',
    //     ]);
    // }

    public function resendOtp(Request $request)
    {
        return OTPHelper::sendOTP($request->phone_number);
    }

}
