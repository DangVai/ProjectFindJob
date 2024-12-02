<?php
include '../controllers/db_connect.php'; // Kết nối cơ sở dữ liệu

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Lấy thông tin người dùng
    $sql_user = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Lấy bài đăng của người dùng
    $sql_posts = "SELECT * FROM posts WHERE user_id = ?";
    $stmt = $conn->prepare($sql_posts);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $posts = $stmt->get_result();

    // Lấy đánh giá về người dùng
    $sql_reviews = "SELECT * FROM reviews WHERE user_id = ?";
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $reviews = $stmt->get_result();
} else {
    echo "Không tìm thấy người dùng.";
    exit;
}
?>
