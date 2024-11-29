<?php
// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "mydatabase", 3306);

// Kiểm tra kết nối
if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Truy vấn dữ liệu
$sql = "SELECT * FROM post";
$result = mysqli_query($connect, $sql);

// Đảm bảo có dữ liệu
$posts = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

// Đóng kết nối
// mysqli_close($connect);
?>
