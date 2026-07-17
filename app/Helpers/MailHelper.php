<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailHelper
{
    /**
     * Send an email using SMTP via PHPMailer
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    private static function sendSMTP($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = config('mail.mailers.smtp.host', 'mail.greenlamindustrieslimited.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('mail.mailers.smtp.username', 'warranty@greenlamindustrieslimited.com');
            $mail->Password   = config('mail.mailers.smtp.password', 'KSGDF5383FD!63YTyw');
            $mail->Port       = config('mail.mailers.smtp.port', 25);

            // Security options
            $security = config('mail.mailers.smtp.encryption', 'none');
            if ($security === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } elseif ($security === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }

            // Custom SSL options to bypass SSL/TLS verification issues if they occur
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $fromAddress = config('mail.from.address', 'warranty@greenlamindustrieslimited.com');
            $fromName    = config('mail.from.name', 'Warranty Notification');
            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags(html_entity_decode($body));

            $mail->send();
            Log::info("SMTP Mail Sent Successfully to $to - Subject: $subject");
            return true;
        } catch (Exception $e) {
            Log::error("SMTP Mail Send Failed to $to: " . $e->getMessage() . " | PHPMailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }

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
        $subject = 'Warranty Request';
        $message = '
        <p>Dear valued customer,</p>
        <p>We are pleased to inform you that your warranty issuance form has been successfully submitted to Greenlam.</p>
        <p>Our team will review the details and process your warranty request shortly.</p>
        <p>Thank you for your trust in Greenlam. We appreciate your association with us and look forward to serving you.</p>
        ';

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMaiCustomerRequestSubmit($to)
    {
        $subject = 'Warranty Request Submitted';
        $message = '
        <p>Dear valued customer,</p>
        <p>We are pleased to inform you that your warranty issuance form has been successfully submitted to Greenlam.</p>
        <p>Our team will review the details and process your warranty request shortly.</p>
        <p>Thank you for your trust in Greenlam. We appreciate your association with us and look forward to serving you.</p>
        ';

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMailCustomerModifyRequired($to)
    {
        $subject = 'Warranty Modification Required';
        $message = '
        <p>Dear customer,</p>
        <p>We have received your warranty request for processing. However, we noticed that certain details require modification before we can proceed.</p>
        <p>Kindly log in to your account at <a href="https://warranty.greenlamindustries.com">Greenlam Warranty Portal</a> make the necessary changes and resubmit your request for our review.</p>
        <p>Thank you for choosing Greenlam. We look forward to completing your warranty process soon.</p>
        ';

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMailRejectedCustomer($to)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear customer,</p>
        <p>We have received your warranty request; however, it has been rejected during our review process.</p>
        <p>To know the detailed status and reason for rejection, please log in to your account at <a href='https://warranty.greenlamindustries.com'>Greenlam Warranty Portal</a> and check the update.</p>
        <p>Thank you for your understanding.</p>";

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMailApprovedCustomer($to)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear customer,</p>
        <p>We are pleased to inform you that your warranty has been successfully issued.</p>
        <p>To download your warranty certificate, please log in to your account at <a href='https://warranty.greenlamindustries.com'>Greenlam Warranty Portal</a>.</p>
        <p>Thank you for choosing Greenlam. We value your trust and look forward to serving you in the future.</p>
        ";

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMailBranchNewRequest($to, $userName)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear $userName,</p>
        <p>A warranty request has been submitted in the portal and is currently pending for your action.</p>
        <p>Request you to kindly log in to your account, review the submitted details, and validate them to proceed with the process.
        <a href='https://warranty.greenlamindustries.com/admin/'>Greenlam Warranty Portal</a></p>
        ";

        return self::sendSMTP($to, $subject, $message);
    }

    public static function sendMailCountryApprovedByBranch($to, $userName)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear $userName,</p>
        <p>A warranty request has been submitted in the portal, the request has been reviewed and approved by the Branch Commercial, is currently pending for your action.</p>
        <p>Request you to kindly log in to your account and act.
        <a href='https://warranty.greenlamindustries.com/admin/'>Greenlam Warranty Portal</a></p>
        ";

        return self::sendSMTP($to, $subject, $message);
    }
}
