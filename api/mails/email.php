<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Email{
    public function sendMail($email, $name, $message) {
        $mail = new PHPMailer();

        // Configure smpt
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'autorect.contactos@gmail.com';
        $mail->Password = 'lgqfvmmsohbkmhip';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configure email
        $mail->setFrom('autorect.contactos@gmail.com', 'Contact Email');
        $mail->addAddress('autorect.contactos@gmail.com');
        $mail->Subject = $email.' - '.$name;
        $mail->Body = $message;

        // Send the mail
        if ($mail->send()) {
            return 1;
        } else {
            return $mail->ErrorInfo;
        }
    }
}
?>