<?php
// Bắt đầu session
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    die("Bạn không có quyền truy cập.");
}

// Kết nối tới cơ sở dữ liệu
require '../config/db.php';

try {
    // Kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy id_post từ URL
    $idPost = (int) $_GET['id'];

    // Kiểm tra xem bài viết có tồn tại không
    $stmtCheck = $conn->prepare("SELECT * FROM post WHERE id_post = :id_post");
    $stmtCheck->bindParam(':id_post', $idPost, PDO::PARAM_INT);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() === 0) {
        die("Bài viết không tồn tại.");
    }

    // Xóa bài viết
    $stmtDelete = $conn->prepare("DELETE FROM post WHERE id_post = :id_post");
    $stmtDelete->bindParam(':id_post', $idPost, PDO::PARAM_INT);
    $stmtDelete->execute();

    // Thông báo thành công
    echo "<script>
        alert('Xóa bài viết thành công!');
        window.location.href = '../public/history.php'; 
    </script>";

} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?>
