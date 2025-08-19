<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Raju\EWSMail\ExchangeMailServer;

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

        $subject = 'Warranty Request';
        $message = '
        <p>Dear valued customer,</p>
        <p>We are pleased to inform you that your warranty issuance form has been successfully submitted to Greenlam.</p>
        <p>Our team will review the details and process your warranty request shortly.</p>
        <p>Thank you for your trust in Greenlam. We appreciate your association with us and look forward to serving you.</p>
        ';

        return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
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
        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
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
        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
    }
    public static function sendMailRejectedCustomer($to)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear customer,</p>
        <p>We have received your warranty request; however, it has been rejected during our review process.</p>
        <p>To know the detailed status and reason for rejection, please log in to your account at <a href='https://warranty.greenlamindustries.com'>Greenlam Warranty Portal</a> and check the update.</p>
        <p>Thank you for your understanding.</p>";

        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
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
        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
    }
    public static function sendMailBranchNewRequest($to,$userName)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear $userName,</p>
        <p>A warranty request has been submitted in the portal and is currently pending for your action.</p>
        <p>Request you to kindly log in to your account, review the submitted details, and validate them to proceed with the process.
        <a href='https://warranty.greenlamindustries.com/admin/'>Greenlam Warranty Portal</a></p>
        ";
        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
    }
    public static function sendMailCountryApprovedByBranch($to,$userName)
    {
        $subject = 'Warranty Request';
        $message = "
        <p>Dear $userName,</p>
        <p>A warranty request has been submitted in the portal, the request has been reviewed and approved by the Branch Commercial, is currently pending for your action.</p>
        <p>Request you to kindly log in to your account and act.
        <a href='https://warranty.greenlamindustries.com/admin/'>Greenlam Warranty Portal</a></p>
        ";
        try {
            return ExchangeMailServer::sendEmail(['name' => '', 'email' => $to], ['subject' => $subject, 'body' => $message]);
        } catch (\Exception $e) {
            Log::error("EWS Mail Send Failed to $to:  " . $e->getMessage());
            return false;
        }
    }

}
