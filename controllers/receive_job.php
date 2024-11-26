<?php
// Kết nối database
require_once("../config/db.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Kiểm tra phương thức là POST
    var_dump($_POST); // Kiểm tra dữ liệu gửi
    if (isset($_POST['receive_job'])) {
        echo "hello"; // Kiểm tra nếu vào đây
        $id_post = $_POST['id_post'];
        $user_id = $_SESSION['user_id']; 
    try {
        // Cập nhật bảng post để lưu ID người nhận
        $sql = "UPDATE post SET recipient_id = :recipient_id WHERE id_post = :id_post";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':recipient_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->execute();

        // Tạo thông báo cho người đăng bài
        $sql = "INSERT INTO notice (user_id, content) VALUES (:user_id, :content)";
        $stmt = $conn->prepare($sql);
        
        // Lấy user_id của người đăng bài từ bảng post
        $sqlPost = "SELECT user_id FROM post WHERE id_post = :id_post";
        $stmtPost = $conn->prepare($sqlPost);
        $stmtPost->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmtPost->execute();

        $post = $stmtPost->fetch(PDO::FETCH_ASSOC);
        $poster_user_id = $post['user_id']; // ID của người đăng bài

        // Tạo nội dung thông báo
        $content = "Người dùng ID $user_id đã nhận công việc của bạn.";
        
        // Ghi thông báo vào bảng notice
        $stmt->bindParam(':user_id', $poster_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
         // Chuyển hướng người dùng đến trang quản lý công việc
         header("Location: ../index.php");
         exit();
         
        // echo "<script>alert('Bạn đã nhận công việc thành công!');</script>";
    } catch (PDOExceptio $e) {
        echo "<script>alert('Lỗi khi lưu dữ liệu: " . $e->getMessage() . "');</script>";
    }
}
}
?>
