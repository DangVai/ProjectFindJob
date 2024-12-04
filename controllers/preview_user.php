<?php
// Kết nối cơ sở dữ liệu
require_once("../config/db.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để đánh giá.");
}

// Lấy user_id từ session
$userId = $_SESSION['user_id'];

// Lấy ID bài viết từ URL
$postId = isset($_GET['id_post']) ? (int)$_GET['id_post'] : 0;
if ($postId <= 0) {
    die("ID bài viết không hợp lệ.");
}

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $soSao = isset($_POST['soSao']) ? (int)$_POST['soSao'] : 0;
    $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';

    // Kiểm tra dữ liệu
    if ($soSao > 0 && !empty($content)) {
        // Câu lệnh SQL để lưu đánh giá vào cơ sở dữ liệu
        $query = "INSERT INTO preview (user_id, id_post, soSao, content) 
                  VALUES (?, ?, ?, ?)";

        // Chuẩn bị và thực thi câu lệnh SQL
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("iiis", $userId, $postId, $soSao, $content);
            if ($stmt->execute()) {
                echo "Đánh giá của bạn đã được gửi thành công!";
            } else {
                echo "Có lỗi khi lưu đánh giá.";
            }
            $stmt->close();
        }
    } else {
        echo "Vui lòng nhập đầy đủ thông tin.";
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
