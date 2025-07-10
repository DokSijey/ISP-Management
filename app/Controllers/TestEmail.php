<?php

namespace App\Controllers;

use App\Libraries\MailSender;

class TestEmail extends BaseController
{
    public function index()
    {
        $mailer = new MailSender();

        // Test details
        $to = 'sijeyit1@gmail.com'; // Change to your test email
        $name = 'Test User';
        $subject = 'Test Invoice Email';
        $body = '<h3>Hello!</h3><p>This is a test email with an invoice attachment.</p>';
        $attachmentPath = WRITEPATH . 'invoices/sample_invoice.pdf'; // Make sure this file exists

        $sent = $mailer->sendInvoice($to, $name, $subject, $body, $attachmentPath);

        if ($sent) {
            return '✅ Email sent successfully!';
        } else {
            return '❌ Failed to send email.';
        }
    }
}
