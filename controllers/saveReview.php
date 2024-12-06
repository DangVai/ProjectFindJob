<?php
require_once '../config/db.php';

session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để gửi đánh giá.");
}

$conn = new mysqli('localhost', 'root', '', 'mydatabase');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // ID người đánh giá (người đang đăng nhập)
    $ratedUserId = intval($_POST['rated_user_id']); // ID người được đánh giá
    $idPost = intval($_POST['id_post']); // ID bài viết
    $soSao = intval($_POST['soSao']);
    $content = $_POST['content'];

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Thực hiện lưu đánh giá
    $stmt = $conn->prepare("INSERT INTO preview (user_id, id_post, rated_user_id, soSao, content) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("iiiis", $userId, $idPost, $ratedUserId, $soSao, $content);

    if ($stmt->execute()) {
        header("Location: ../public/viewProfile.php?user_id=$ratedUserId&message=success");
        exit;
    } else {
        die("Lỗi khi lưu đánh giá: " . $stmt->error);
    }
}
?>
