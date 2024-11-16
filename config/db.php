<?php
// config/db.php
$host = "localhost";
$db_name = "job_portal";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối thành công!"; // Thêm dòng này để xác nhận kết nối
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>