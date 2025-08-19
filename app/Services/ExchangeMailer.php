<?php

namespace App\Services;

use garethp\ews\API;
use Illuminate\Support\Facades\Log;

class ExchangeMailer
{
    protected static function connect()
    {
        return API::withUsernameAndPassword(
            'https://email.greenlam.com/EWS/Exchange.asmx',
            'warranty1',
            'TimeP@$$#2025'
        );
    }

    public static function send($to, $subject, $bodyHtml)
    {
        try {
            $api = self::connect();

            $message = [
                'Subject' => $subject,
                'Body' => [
                    'BodyType' => 'HTML',
                    '_value' => $bodyHtml
                ],
                'ToRecipients' => [
                    ['EmailAddress' => $to]
                ]
            ];

            $api->getMail()->sendMessage($message);

            return true;
        } catch (\Exception $e) {
            Log::error('EWS Mail Send Failed: ' . $e->getMessage());
            return false;
        }
    }
}
