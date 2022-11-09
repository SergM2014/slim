<?php

namespace App\Infrastructure;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function send($email, $resetToken): void 
    {
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

        //From email address and name
        $mail->From = "from@yourdomain.com";
        $mail->FromName = "Full Name";

        //To address and name
        // $mail->addAddress("recepient1@example.com", "Recepient Name");
        $mail->addAddress($email); //Recipient name is optional

        //Address to which recipient will reply
        $mail->addReplyTo("reply@yourdomain.com", "Reply");

        //CC and BCC
        // $mail->addCC("cc@example.com");
        // $mail->addBCC("bcc@example.com");

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "Subject Text";
        $mail->Body = "<i>Mail body in HTML</i>";
       
        $mail ->Body = "<p>In order to reset Your password click folowing link during next 2 hours</p>
             <a href='/change_password?token=${resetToken}'>Reset Password</a>
            ";
        $mail->AltBody = "This is the plain text version of the email content";

        // try {
            $mail->send();
        //     echo "Message has been sent successfully";
        // } catch (Exception $e) {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // }
    }
}