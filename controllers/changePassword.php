<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        header("Location: ../public/profile.php?message=error_password_mismatch");
        exit();
    }

    // $conn = new mysqli("localhost", "root", "", "mydatabase");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($old_password, $hashed_password)) {
        header("Location: ../public/profile.php?message=error_wrong_password");
        exit();
    }

    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $sql_update = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $new_hashed_password, $user_id);
    $stmt_update->execute();
    $stmt_update->close();

    header("Location: ../public/profile.php?message=success");
    exit();
}
?>
