<?php
session_start();
require_once '../config/db.php';

class AuthController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($data)
    {
        $fullname = $data['fullname'] ?? '';
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $password = $data['password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';

        // Kiểm tra mật khẩu có giống nhau không
        if ($password !== $confirm_password) {
            $this->redirectWithError('password_mismatch');
        }

        // Kiểm tra độ dài mật khẩu (ít nhất 6 ký tự)
        if (strlen($password) < 6) {
            $this->redirectWithError('password_too_short');
        }

        // Kiểm tra độ dài số điện thoại (ít nhất 11 ký tự)
        if (strlen($phone) < 10) {
            $this->redirectWithError('phone_too_short');
        }

        // Kiểm tra username, email và phone đã tồn tại chưa
        if ($this->isFieldExists('username', $username)) {
            $this->redirectWithError('username_exists');
        }

        if ($this->isFieldExists('email', $email)) {
            $this->redirectWithError('email_exists');
        }

        if ($this->isFieldExists('phone', $phone)) {
            $this->redirectWithError('phone_exists');
        }

        // Mã hóa mật khẩu bằng password_hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thực hiện câu lệnh SQL để đăng ký
        $sql = "INSERT INTO users (fullname, username, email, phone, password) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            $this->redirectWithError('db_error');
        }

        $stmt->bind_param("sssss", $fullname, $username, $email, $phone, $hashed_password);

        if ($stmt->execute()) {
            // Lưu thông tin vào session
            $_SESSION['con-email'] = $email;
            $_SESSION['con-fullname'] = $fullname;
            $_SESSION['con-username'] = $username;
            $_SESSION['con-phone'] = $phone;

            // Chuyển hướng đến sendmail.php để gửi email
            header("Location: ../PHPMailer-master/sendEmail.php?inform=success");
            exit();
        } else {
            $this->redirectWithError('fail');
        }
    }
    private function isFieldExists($field, $value)
    {
        $sql = "SELECT * FROM users WHERE $field = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            $this->redirectWithError('db_error');
        }

        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    private function redirectWithError($error)
    {
        header("Location: ../public/register.php?error=$error");
        exit();
    }
}

// Xử lý đăng ký
if (isset($_POST['register'])) {
    $userRegistration = new AuthController($conn);
    $userRegistration->register($_POST);
} else {
    header("Location: ../public/register.php");
    exit();
}
?>