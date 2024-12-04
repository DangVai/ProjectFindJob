<?php
// Kết nối với cơ sở dữ liệu
require_once("../config/db.php");

session_start();
$id_post = isset($_GET['id_post']) ? intval($_GET['id_post']) : null;
if (!$id_post) {
    die("Không có ID bài đăng.");
}

try {
    $sql = "
    SELECT p.id_post, p.role, p.price, p.linh_vuc, p.noi_dung, p.dia_chi, p.thoi_gian, p.anh_cong_viec, p.goi_dang_ky, pr.link_anh
    FROM post p
    JOIN profile pr ON p.user_id = pr.user_id
    WHERE p.id_post = :id_post
    ";

    $stmt = $conn->prepare($sql);  
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT); 
    $stmt->execute(); 

    // Kiểm tra xem có bài viết nào được tìm thấy không
    if ($stmt->rowCount() > 0) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['post'] = $post;
        
        header("Location: ../public/details_job.php");
        exit(); 
    } else {
        echo "Không tìm thấy bài đăng.";
    }
} catch (PDOException $e) {
    // Nếu có lỗi trong quá trình truy vấn, in thông báo lỗi
    echo "Lỗi khi truy vấn dữ liệu: " . $e->getMessage();
}
?>
<!-- /////////////////// -->