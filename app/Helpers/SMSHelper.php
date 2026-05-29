<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSHelper
{
    // ---------------------------------------------------------------
    // DLT-approved template IDs
    // ---------------------------------------------------------------
    private const TEMPLATE_SUBMITTED = '1207177969112212363';
    private const TEMPLATE_REJECTED  = '1207177969066058323';
    private const TEMPLATE_MODIFY    = '1207177969698139590';
    private const TEMPLATE_APPROVED  = '1207177969163177960';

    // Shared gateway credentials / meta
    private const USERNAME  = 'greenlam';
    private const PASSWORD  = 'plywood1';
    private const SENDER    = 'GLIAPP';
    private const PEID      = '1201159980423620375';
    private const HEADER_ID = '1205160017196213320';
    private const GATEWAY   = 'https://bulksms.analyticsmantra.com/sendsms/sendsms.php';

    // ---------------------------------------------------------------
    // Public template helpers
    // ---------------------------------------------------------------

    /**
     * Warranty request submitted / under review.
     * Template: "Your warranty request {1} has been submitted successfully and is under review.
     *            Track status at https://warranty.greenlamindustries.com. Greenlam Industries Ltd"
     */
    public static function sendSMSSubmitted(string $phoneNumber, string $requestId): void
    {
        $message = "Your warranty request {$requestId}  has been submitted successfully and is under review. Track status at https://warranty.greenlamindustries.com. Greenlam Industries Ltd";
        self::dispatch($phoneNumber, $message, self::TEMPLATE_SUBMITTED);
    }

    /**
     * Warranty request rejected.
     * Template: "Your warranty request {1} has been rejected. Please check details at
     *            https://warranty.greenlamindustries.com. Greenlam Industries Ltd"
     */
    public static function sendSMSRejected(string $phoneNumber, string $requestId): void
    {
        $message = "Your warranty request {$requestId}  has been rejected. Please check details at https://warranty.greenlamindustries.com. Greenlam Industries Ltd";
        self::dispatch($phoneNumber, $message, self::TEMPLATE_REJECTED);
    }

    /**
     * Warranty request requires modification.
     * Template: "Your request {1} requires modification. Please log in to
     *            https://warranty.greenlamindustries.com. Greenlam Industries Ltd"
     */
    public static function sendSMSModify(string $phoneNumber, string $requestId): void
    {
        $message = "Your request {$requestId}  requires modification. Please log in to https://warranty.greenlamindustries.com. Greenlam Industries Ltd ";
        self::dispatch($phoneNumber, $message, self::TEMPLATE_MODIFY);
    }

    /**
     * Warranty request approved.
     * Template: "Your warranty request {1} has been approved. Download your warranty certificate from
     *            https://warranty.greenlamindustries.com. Greenlam Industries Ltd"
     */
    public static function sendSMSApproved(string $phoneNumber, string $requestId): void
    {
        $message = " Your warranty request {$requestId}  has been approved. Download your warranty certificate from https://warranty.greenlamindustries.com. Greenlam Industries Ltd";
        self::dispatch($phoneNumber, $message, self::TEMPLATE_APPROVED);
    }

    // ---------------------------------------------------------------
    // Legacy generic sender (kept for backward compatibility)
    // ---------------------------------------------------------------

    /**
     * Send an SMS message directly using the bulk SMS gateway.
     * NOTE: Prefer the template-specific methods above for DLT compliance.
     *
     * @param string $phoneNumber The mobile number to send to (10 digits)
     * @param string $message     The message content
     */
    public static function sendSMS(string $phoneNumber, string $message): void
    {
        self::dispatch($phoneNumber, $message, null);
    }

    // ---------------------------------------------------------------
    // Internal dispatcher
    // ---------------------------------------------------------------

    /**
     * Fire the HTTP request to the SMS gateway.
     *
     * @param string      $phoneNumber
     * @param string      $message
     * @param string|null $templateId  DLT template ID (null = omit parameter)
     */
    private static function dispatch(string $phoneNumber, string $message, ?string $templateId): void
    {
        $params = [
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
            'type'     => 'TEXT',
            'sender'   => self::SENDER,
            'mobile'   => $phoneNumber,
            'message'  => $message,
            'PEID'     => self::PEID,
            'HeaderId' => self::HEADER_ID,
        ];

        if ($templateId !== null) {
            $params['templateId'] = $templateId;
        }

        try {
            $response = Http::get(self::GATEWAY, $params);

            if ($response->successful()) {
                Log::info("SMS sent to {$phoneNumber} (template: " . ($templateId ?? 'none') . "). Response: " . $response->body());
            } else {
                Log::warning("SMS failed to {$phoneNumber}. Status: {$response->status()}. Response: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("SMS exception for {$phoneNumber}: " . $e->getMessage());
        }
    }
}

