<?php 

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    public function send($to, $name, $subject, $body, $attachmentPath = null)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'allstartechinternetservices@gmail.com';
            $mail->Password   = 'rzuu chmk yrla mlvo'; // Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('allstartechinternetservices@gmail.com', 'Allstar Tech Wireless Hotspot and Internet Services');
            $mail->addAddress($to, $name);

            // Optional attachment
            if ($attachmentPath !== null && file_exists($attachmentPath)) {
                $mail->addAttachment($attachmentPath);
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'PHPMailer error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
