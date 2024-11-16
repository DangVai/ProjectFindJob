<?php
session_start();
require_once '../config/db.php';
require_once '../models/User.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header("Location: ../views/login.php");
    exit();
}

$conn = new PDO("mysql:host=localhost;dbname=job_portal", "root", "");

// Lấy user_id từ session
$user_id = $_SESSION['user']['id']; // Giả sử thông tin người dùng lưu trong session có khóa 'id'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $content = $_POST['content'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];
    $health_request = $_POST['health_request'];

    // Xử lý upload hình ảnh nếu có
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Thêm dữ liệu vào cơ sở dữ liệu
    try {
        $stmt = $conn->prepare("INSERT INTO job_posts (user_id, content, address, image, salary, health_request) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $content, $address, $image, $salary, $health_request]);

        echo "Dữ liệu đã được thêm thành công!";
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>