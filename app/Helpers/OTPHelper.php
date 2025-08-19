<?php

namespace App\Helpers;

use App\Models\Otp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OTPHelper
{

    public static function sendOTP($phone_number)
    {
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        Otp::updateOrCreate(
            ['phone_number' => $phone_number],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        $message = "$otp is the OTP to login Greenlam Warranty Portal.Greenlam Industries Ltd";

        $url = "https://bulksms.analyticsmantra.com/sendsms/sendsms.php";
        $params = [
            'username' => 'greenlam',
            'password' => 'plywood1',
            'type' => 'TEXT',
            'sender' => 'GLIAPP',
            'mobile' => $phone_number,
            'message' => $message,
            'PEID' => '1201159980423620375',
            'HeaderId' => '1205160017196213320',
            'templateId' => '1207175437985868276',
        ];


        try {
            $response = Http::get($url, $params);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent for login',
                'otp' => $otp, // remove in production
                'response' => $response->body(),
            ]);

        } catch (\Exception $e) {
            Log::error("Error sending OTP at " . now()->format('Y-m-d H:i:s') . " for $phone_number:  " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
