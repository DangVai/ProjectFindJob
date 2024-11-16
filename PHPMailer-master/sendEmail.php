<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Kiểm tra nếu email và fullname đã được lưu trong session
if (!isset($_SESSION['con-email']) || !isset($_SESSION['con-fullname'])) {
    die("Không tìm thấy thông tin người dùng.");
}

$email = $_SESSION['con-email'];
$fullname = $_SESSION['con-fullname'];
$username = $_SESSION['con-username'];
$phone = $_SESSION['con-phone'];

$mail = new PHPMailer(true);

try {
    // Cấu hình server SMTP
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dangvai30@gmail.com';
    $mail->Password = 'vhjz fvwk huze xbqs';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Người nhận
    $mail->setFrom('dangvai30@gmail.com', 'Dang Vai Shop');
    $mail->addAddress($email, $fullname);
    $mail->addReplyTo('dangvai30@gmail.com', 'Dang Vai Shop');

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = 'Chuc mung dang ky thanh cong!';
    $mail->Body = "<h1>Xin chào $fullname!</h1><p>Cảm ơn bạn đã đăng ký tài khoản với chúng tôi. Dưới đây là thông tin bạn đã đăng ký:</p>
                   <ul>
                       <li><b>Họ và tên:</b> $fullname</li>
                       <li><b>Username:</b> $username</li>
                       <li><b>Phone:</b> $phone</li>
                       <li><b>Email:</b> $email</li>
                   </ul>
                   <p>Chúc bạn có những trải nghiệm tuyệt vời!</p>";
    $mail->AltBody = "Xin chào $fullname! Cảm ơn bạn đã đăng ký tài khoản với chúng tôi.";

    // Gửi email
    $mail->send();

} catch (Exception $e) {
    die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}
header("Location:../public/login.php?rs=success");
exit();
?>