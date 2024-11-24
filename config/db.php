<?php
// Thông tin kết nối cơ sở dữ liệu
$host = "localhost";        
$db_name = "mydatabase";    
$username = "root";         
$password = "";             

// Kết nối đến cơ sở dữ liệu bằng PDO
try {
    // Cấu hình DSN (Data Source Name) để kết nối với cơ sở dữ liệu MySQL
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Lỗi kết nối cơ sở dữ liệu: " . $exception->getMessage();
    die();  // Dừng script nếu không thể kết nối
}
?>
