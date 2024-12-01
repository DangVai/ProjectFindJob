<?php
require_once '../config/db.php';

// Kiểm tra nếu có POST yêu cầu "like" và bài viết
if (isset($_POST['like']) && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $sender_id = intval($_POST['sender_id']); // ID của người like bài viết

    // Lấy thông tin người đăng bài viết
    $query = "SELECT user_id FROM post WHERE id_post = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        $receiver_id = $post['user_id'];

        // Tạo thông báo
        $message = "Có người <a href='profile.php?user_id=$sender_id'>này</a> đã thích bài viết của bạn. 
                    Xem bài viết tại <a href='post.php?id=$post_id'>đây</a>.";

        // Insert vào bảng notifications
        $insertNotification = "INSERT INTO notifications (sender_id, receiver_id, post_id, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertNotification);
        $stmt->bind_param('iiis', $sender_id, $receiver_id, $post_id, $message);

        if ($stmt->execute()) {
            echo "Thông báo đã được gửi!";
        } else {
            echo "Lỗi khi gửi thông báo: " . $conn->error;
        }
    } else {
        echo "Không tìm thấy bài viết.";
    }
}
?>