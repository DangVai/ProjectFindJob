<?php
$connect = mysqli_connect("localhost", "root", "", "mydatabase", 3306);

$sql = "SELECT * FROM post";
$result = mysqli_query($connect, $sql);
$posts = [];
while ($row = mysqli_fetch_array($result)) {
    $posts[] = $row;
}

// lấy dữ liệu từ php về lưu vào array
