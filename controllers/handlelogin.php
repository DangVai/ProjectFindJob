<?php
session_start();
require_once '../config/db.php';

class Auth
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Hàm đăng nhập
    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'error' => 'wrong_password'];
            }
        }
        return ['success' => false, 'error' => 'email_not_found'];
    }

    // Hàm để lưu thông tin người dùng vào session
    public function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['fullname'];
        $_SESSION['email'] = $user['email'];
    }

    // Hàm để xử lý đăng nhập
    public function processLogin($email, $password)
    {
        if (!empty($email) && !empty($password)) {
            $loginResult = $this->login($email, $password);
            if ($loginResult['success']) {
                $user = $loginResult['user'];
                $this->setUserSession($user); // Lưu thông tin vào session
                header("Location: ../index.php");
                exit();
            } else {
                $error = $loginResult['error'];
                header("Location: ../public/login.php?error=$error");
                exit();
            }
        } else {
            header("Location: ../public/login.php?error=missing_fields");
            exit();
        }
    }
}

// Tạo đối tượng Auth và xử lý đăng nhập
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $auth = new Auth($conn);
    $auth->processLogin($email, $password);
}
?>