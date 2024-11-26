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

    // Kiểm tra mật khẩu bằng password_verify
    if ($user && password_verify($password, $user['password'])) {
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
            $_SESSION['email'] = $user['email']; // Lưu email
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../public/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: ../public/login.php?error=missing_fields");
        exit();
    }
}

?>