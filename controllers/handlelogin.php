<?php
session_start();
require_once '../config/db.php';
function login($conn, $email, $password)
{
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && md5($password) === $user['password']) {
        return $user;
    }
    return false;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $user = login($conn, $email, $password);
        if ($user) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['fullname'];
            // Sau khi đăng nhập thành công, lưu email vào session
            $_SESSION['email'] = $user['email'];  // Giả sử $user là thông tin người dùng lấy từ cơ sở dữ liệu
            header("Location: ../index.php"); // Chuyển hướng đến trang index sau khi đăng nhập thành công
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
?>