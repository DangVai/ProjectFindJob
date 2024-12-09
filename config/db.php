<?php
// config/db.php
$host = "localhost";

$db_name = "mydatabase";

$username = "root";
$password = "1234";

// Kết nối mysqli
 $conn = mysqli_connect($host, $username, $password, $db_name);

if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}
?>
