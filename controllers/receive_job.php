<?php
require_once("../config/db.php");
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    die("Bạn cần đăng nhập để thực hiện hành động này.");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_post'], $_POST['job_title'], $_POST['receiver_id'])) {
        $postId = $_POST['id_post'];
        $jobTitle = $_POST['job_title'];
        $receiverId = $_POST['receiver_id']; // ID người đăng bài
        $senderId = $_SESSION['user_id'];    
        $senderName = $_SESSION['username']; 

        if ($senderId === $receiverId) {
            echo "<script>alert('Bạn không thể nhận công việc của chính mình.'); window.location.href='../index.php?id=$postId';</script>";
            exit(); // Thoát khỏi script ngay lập tức
        }

        try {
            // Tạo thông báo
            $notificationMessage = "Tôi là $senderName nhận công việc <a href='../public/details_job.php?id=$postId' target='_blank'>$jobTitle</a>.";

            // Chèn thông báo vào bảng notifications nếu sender khác receiver
            $stmt = $conn->prepare("INSERT INTO notifications (sender_id, receiver_id, id_post, message, user_id) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Lỗi chuẩn bị câu truy vấn: " . $conn->error);
            }
            $stmt->bind_param('iiisi', $senderId, $receiverId, $postId, $notificationMessage, $receiverId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Thông báo đã được gửi thành công!'); window.location.href='../index.php?id=$postId';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại.'); window.location.href='../index.php?id=$postId';</script>";
            }
        } catch (Exception $e) {
            die("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    } else {
        die("Thiếu thông tin cần thiết.");
    }
} else {
    die("Yêu cầu không hợp lệ.");
}

$stmt = $conn->prepare("SELECT * FROM notifications WHERE receiver_id = ? AND sender_id != ?");
$stmt->bind_param('ii', $_SESSION['user_id'], $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<p>" . htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8') . "</p>";
}
?>
