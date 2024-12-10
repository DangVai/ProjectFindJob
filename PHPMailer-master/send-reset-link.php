<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Biến kiểm tra trạng thái gửi email
$isEmailSent = false;

// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'mydatabase');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Kiểm tra xem email có tồn tại không
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email tồn tại, gửi liên kết đặt lại mật khẩu
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dangvai30@gmail.com';
            $mail->Password = 'vhjz fvwk huze xbqs';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Cấu hình email
            $mail->setFrom('dangvai30@gmail.com', 'Your Website'); // Thay bằng email của bạn
            $mail->addAddress($email); // Gửi email đến người dùng
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            $mail->Body = "
                <h3>Password Reset Request</h3>
                <p>Click the link below to reset your password:</p>
                <a href='http://localhost/findjob3/ProjectFindJob/public/reset-password.php?email=$email'>Reset Password</a>
            ";

            // Gửi email
            $mail->send();
            $isEmailSent = true; // Cập nhật biến khi email gửi thành công
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email does not exist in our records.";
    }

    $stmt->close();
    $conn->close();
}
?>