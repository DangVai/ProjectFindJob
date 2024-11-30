<?php
require '../config/db.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (!empty($email)) {
        // Kiểm tra email có tồn tại
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Tạo token đặt lại mật khẩu
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Lưu token và thời hạn vào database
            $updateQuery = "UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "sss", $token, $expiry, $email);
            mysqli_stmt_execute($updateStmt);

            // Tạo liên kết đặt lại mật khẩu
            $resetLink = "http://yourwebsite.com/reset-password.php?token=$token";

            // Gửi email với PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dangvai30@gmail.com';
                $mail->Password = 'vhjz fvwk huze xbqs';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('dangvai30@gmail.com', 'Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Hello,<br><br>
                    You requested to reset your password. Click the link below to reset it:<br><br>
                    <a href='$resetLink'>Reset Password</a><br><br>
                    If you did not request this, please ignore this email.<br><br>
                    Thank you.";

                $mail->send();
                header("Location: ../public/login.php?message=email_sent");
                exit();
            } catch (Exception $e) {
                header("Location: ../public/login.php?error=email_failed");
                exit();
            }
        } else {
            header("Location: ../public/login.php?error=email_not_found");
            exit();
        }
    } else {
        header("Location: ../public/login.php?error=missing_email");
        exit();
    }
}
?>