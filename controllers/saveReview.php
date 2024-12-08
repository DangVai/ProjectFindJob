<?php
require_once '../config/db.php';  // Kết nối cơ sở dữ liệu
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để gửi đánh giá.");
}

$conn = new mysqli('localhost', 'root', '1234', 'mydatabase');  // Kết nối cơ sở dữ liệu

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $userId = $_SESSION['user_id'];  // Người dùng đang đăng nhập
    $ratedUserId = intval($_POST['rated_user_id']);  // Người dùng nhận đánh giá
    $idPost = intval($_POST['id_post']);  
    $soSao = intval($_POST['soSao']);  // Đánh giá sao
    $content = $_POST['content'];  // Nội dung đánh giá

    // Kiểm tra xem người dùng có đang cố gắng đánh giá bài viết của chính mình không
    if ($userId === $ratedUserId) {
        die("Bạn không thể tự đánh giá bài viết của mình.");
    }

    // Kiểm tra dữ liệu có hợp lệ không
    if (empty($content)) {
        die("Nội dung không thể để trống.");
    }

    // Thực hiện lưu đánh giá vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO preview (user_id, id_post, rated_user_id, soSao, content) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    // Gắn giá trị cho các tham số trong câu truy vấn
    $stmt->bind_param("iiiis", $userId, $idPost, $ratedUserId, $soSao, $content);

    // Thực thi câu truy vấn
    if ($stmt->execute()) {
        // Nếu thành công, chuyển hướng về trang profile của người được đánh giá
        header("Location: ../public/viewProfile.php?user_id=$ratedUserId&message=success");
        exit;
    } else {
        die("Lỗi khi lưu đánh giá: " . $stmt->error);
    }
}
?>
