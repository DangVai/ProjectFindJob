<?php
// Kết nối với cơ sở dữ liệu
require_once("../config/db.php");

session_start();

// Kiểm tra xem id_post có được truyền qua URL hay không
$id_post = isset($_GET['id_post']) ? intval($_GET['id_post']) : null;

// Nếu không có id_post, dừng script và thông báo lỗi
if (!$id_post) {
    die("Không có ID bài đăng.");
}

try {
    // Truy vấn lấy thông tin chi tiết bài viết từ bảng `post` dựa trên id_post ( có sủa lại)
    $sql = "
    SELECT p.id_post, p.role, p.price, p.linh_vuc, p.noi_dung, p.dia_chi, p.thoi_gian, p.anh_cong_viec, p.goi_dang_ky, pr.link_anh
    FROM post p
    JOIN profile pr ON p.user_id = pr.user_id
    WHERE p.id_post = :id_post
    ";

    $stmt = $conn->prepare($sql);  // Chuẩn bị câu lệnh SQL
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);  // Gắn giá trị id_post vào câu lệnh
    $stmt->execute();  // Thực thi câu lệnh SQL

    // Kiểm tra xem có bài viết nào được tìm thấy không
    if ($stmt->rowCount() > 0) {
        // Nếu tìm thấy bài viết, lấy dữ liệu bài viết
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Lưu dữ liệu bài viết vào session để sử dụng ở trang khác
        $_SESSION['post'] = $post;
        
        // Chuyển hướng người dùng đến trang chi tiết bài đăng
        header("Location: ../public/details_job.php");
        exit();  // Dừng mã sau khi chuyển hướng
    } else {
        // Nếu không tìm thấy bài viết, thông báo lỗi
        echo "Không tìm thấy bài đăng.";
    }
} catch (PDOException $e) {
    // Nếu có lỗi trong quá trình truy vấn, in thông báo lỗi
    echo "Lỗi khi truy vấn dữ liệu: " . $e->getMessage();
}
?>
<!-- /////////////////// -->
