<?php
require_once '../config/db.php';
function getUserProfile($userId, $conn) {
    // Kiểm tra kết nối cơ sở dữ liệu
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn thông tin người dùng và profile
    $query = "
        SELECT 
            u.*, 
            pr.link_anh AS profile_picture, 
            pr.address, 
            pr.gender, 
            pr.birthday, 
            pr.danh_gia 
        FROM 
            users u
        LEFT JOIN profile pr ON u.user_id = pr.user_id
        WHERE u.user_id = ?
    ";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        // Truy vấn các bài viết của người dùng
        $postsQuery = "SELECT * FROM post WHERE user_id = ?";
        $postsStmt = $conn->prepare($postsQuery);
        if ($postsStmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        $postsStmt->bind_param("i", $userId);
        $postsStmt->execute();
        $user['posts'] = $postsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Truy vấn các đánh giá của người dùng
        $reviewsQuery = "
            SELECT 
                p.soSao, 
                p.content, 
                u.fullname AS reviewer_name
            FROM 
                preview p
            JOIN users u ON p.user_id = u.user_id
            WHERE p.rated_user_id = ?
        ";
        $reviewsStmt = $conn->prepare($reviewsQuery);
        if ($reviewsStmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        $reviewsStmt->bind_param("i", $userId);
        $reviewsStmt->execute();
        $user['reviews'] = $reviewsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    return $user;
}

?>
