<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class MailHelper
{
    /**
     * Send a simple email
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public static function sendMail($to, $subject, $message)
    {
        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject);
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
