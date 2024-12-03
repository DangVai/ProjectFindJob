<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $user_id = $_SESSION['user_id'];

    $conn = new mysqli("localhost", "root", "", "mydatabase");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Xóa từ bảng profile trước
    $sql_delete_profile = "DELETE FROM profile WHERE user_id = ?";
    $stmt_profile = $conn->prepare($sql_delete_profile);
    $stmt_profile->bind_param("i", $user_id);
    $stmt_profile->execute();
    $stmt_profile->close();

    // Xóa từ bảng users
    $sql_delete_user = "DELETE FROM users WHERE user_id = ?";
    $stmt_user = $conn->prepare($sql_delete_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $stmt_user->close();

    session_destroy();
    header("Location: ../public/login.php?message=account_deleted");
    exit();
}
?>
