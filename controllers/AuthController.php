<?php
session_start();
require_once '../config/db.php';

$conn = mysqli_connect("localhost", "root", "", "mydatabase");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Kiểm tra mật khẩu có giống nhau không
    if ($password !== $confirm_password) {
        header("Location: ../public/register.php?error=password_mismatch");
        exit();
    }

    // Mã hóa mật khẩu bằng md5
    $hashed_password = md5($password);

    // Thực hiện câu lệnh SQL để đăng ký
    $sql = "INSERT INTO users (fullname, username, email, phone, password) 
            VALUES ('$fullname', '$username', '$email', '$phone', '$hashed_password')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Lưu email vào session để gửi email
        $_SESSION['con-email'] = $email;
        $_SESSION['con-fullname'] = $fullname;
        $_SESSION['con-username'] = $username;
        $_SESSION['con-phone'] = $phone;
        // Chuyển hướng đến sendmail.php để gửi email
        header("Location: ../PHPMailer-master/sendEmail.php?inform=success");
        exit();
    } else {
        header("Location: ../public/register.php?error=fail");
        exit();
    }

} else {
    header("Location: ../public/register.php");
    exit();
}
?>