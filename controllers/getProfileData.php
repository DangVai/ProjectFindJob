<?php
require_once '../config/db.php';

function getUserProfile($userId, $conn) {
    // Lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT u.fullname, u.email, u.phone, p.link_anh, p.address, p.gender, p.birthday, p.danh_gia 
                            FROM users u
                            LEFT JOIN profile p ON u.user_id = p.user_id
                            WHERE u.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $userData = $userResult->fetch_assoc();

    // Lấy danh sách bài viết
    $stmt = $conn->prepare("SELECT * FROM post WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $postsResult = $stmt->get_result();
    $userData['posts'] = $postsResult->fetch_all(MYSQLI_ASSOC);

    // Lấy danh sách đánh giá
    $stmt = $conn->prepare("SELECT p.soSao, p.content, u.fullname as reviewer_name 
                            FROM preview p
                            JOIN users u ON p.user_id = u.user_id
                            WHERE p.rated_user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $reviewsResult = $stmt->get_result();
    $userData['reviews'] = $reviewsResult->fetch_all(MYSQLI_ASSOC);

    return $userData;
}
?>
