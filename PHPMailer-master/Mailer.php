
<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public function sendVerificationEmail($email, $fullname, $verification_code)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dangvai30@gmail.com';
            $mail->Password = 'vhjz fvwk huze xbqs';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dangvai30@gmail.com', 'Your Website Name');
            $mail->addAddress($email, $fullname);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $verification_link = "http://localhost/findjob1/ProjectFindJob/controllers/verify_email.php?code=$verification_code";
            $mail->Body = "
            <h1>Hello $fullname!</h1>
            <p>Thank you for registering. Please click the link below to verify your email address:</p>
            <a href='$verification_link'>Verify Email</a>
            <p>If you did not register, please ignore this email.</p>
        ";
            $mail->send();
        } catch (Exception $e) {
            die("Error sending verification email: {$mail->ErrorInfo}");
        }
    }
}
?>