<?php
session_start();
require_once '../config/db.php'; // Kết nối cơ sở dữ liệu
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($data)
    {
        $fullname = trim($data['fullname'] ?? '');
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $password = trim($data['password'] ?? '');
        $confirm_password = trim($data['confirm_password'] ?? '');

        // Kiểm tra mật khẩu
        if ($password !== $confirm_password) {
            $this->redirectWithError('password_mismatch');
        }

        if (strlen($password) < 6) {
            $this->redirectWithError('password_too_short');
        }

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError('invalid_email');
        }

        // Kiểm tra số điện thoại
        if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
            $this->redirectWithError('invalid_phone');
        }

        // Kiểm tra trùng lặp username, email, phone
        if ($this->isFieldExists('username', $username)) {
            $this->redirectWithError('username_exists');
        }
        if ($this->isFieldExists('email', $email)) {
            $this->redirectWithError('email_exists');
        }
        if ($this->isFieldExists('phone', $phone)) {
            $this->redirectWithError('phone_exists');
        }

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tạo OTP
        $otp = random_int(100000, 999999); // Mã OTP 6 chữ số

        // Thêm người dùng vào bảng pending_users
        $sql = "INSERT INTO pending_users (fullname, username, email, phone, password, otp, otp_created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            $this->redirectWithError('db_error');
        }

        $stmt->bind_param("ssssss", $fullname, $username, $email, $phone, $hashed_password, $otp);

        if ($stmt->execute()) {
            // Lưu email vào session
            $_SESSION['email'] = $email;

            // Gửi email chứa mã OTP
            if ($this->sendOtpEmail($email, $fullname, $otp)) {
                header("Location: ../public/register.php?success=otp_sent");
                exit();
            } else {
                $this->redirectWithError('email_failed');
            }
        } else {
            $this->redirectWithError('registration_failed');
        }
    }

    private function isFieldExists($field, $value)
    {
        $sql = "SELECT * FROM pending_users WHERE $field = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            $this->redirectWithError('db_error');
        }

        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    private function sendOtpEmail($email, $fullname, $otp)
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

            $mail->setFrom('dangvai30@gmail.com', 'Dang Vai Shop');
            $mail->addAddress($email, $fullname);
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "Hi $fullname,<br>Your verification code is: <strong>$otp</strong>.<br>
                Please enter this code on the verification page to activate your account.";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    private function redirectWithError($error)
    {
        header("Location: ../public/register.php?error=$error");
        exit();
    }
}

// Xử lý khi người dùng nhấn nút đăng ký
if (isset($_POST['register'])) {
    $auth = new AuthController($conn);
    $auth->register($_POST);
} else {
    header("Location: ../public/register.php");
    exit();
}
