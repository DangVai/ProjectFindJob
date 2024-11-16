<?php
session_start();
require_once '../config/db.php';

$conn = mysqli_connect("localhost", "root", "", "job_portal");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

function login($conn, $email, $password)
{
    // Truy vấn người dùng theo email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Mã hóa mật khẩu đầu vào bằng md5 và so sánh với mật khẩu trong cơ sở dữ liệu
    if ($user && md5($password) === $user['password']) {
        return $user;
    }
    return false;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kiểm tra các trường nhập liệu
    if (!empty($email) && !empty($password)) {
        $user = login($conn, $email, $password);
        if ($user) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = [
                'name' => $user['fullname'],
                'email' => $user['email']
            ];
            header("Location: ../index.php"); // Chuyển hướng đến trang hiển thị thông tin người dùng
            exit();
        } else {
            header("Location: ../public/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: ../views/login.php?error=missing_fields");
        exit();
    }
}
