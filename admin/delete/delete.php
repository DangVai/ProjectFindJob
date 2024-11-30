<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydatabase";

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý yêu cầu xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_post'])) {
    $id_post = intval($_POST['id_post']); // Lấy id_post từ yêu cầu POST

    // Câu lệnh SQL để xóa dữ liệu
    $sql = "DELETE FROM post WHERE id_post = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_post);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

// Đóng kết nối
$conn->close();
?>