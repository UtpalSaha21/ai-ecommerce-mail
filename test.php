<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'absutpal321@gmail.com';
    $mail->Password   = 'zfen sfmo ilmj qdlf'; // App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('absutpal321@gmail.com','AI System');
    $mail->addAddress('utpalsaha221@gmail.com'); // Test receiver

    $mail->Subject = "Test Email";
    $mail->Body    = "PHPMailer working successfully.";

    $mail->send();

    echo "Email Sent Successfully";

} catch (Exception $e) {

    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
