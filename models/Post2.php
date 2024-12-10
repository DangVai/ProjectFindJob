<?php
// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "1234", "mydatabase", 3306);

// Kiểm tra kết nối
if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (isset($_POST['search-button']))  {
    $seTitle = $_POST['search-title'];
    $seAddress = $_POST['search-address'];
}
else {
    $seTitle = "";
    $seAddress = "";
}
// Truy vấn dữ liệu
$sql = "SELECT * FROM post where linh_vuc like '%$seTitle%'  and dia_chi like '%$seAddress%'";
$result = mysqli_query($connect, $sql);
// Đảm bảo có dữ liệu
$posts = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}else{
    $posts=[];
}
// Truy vấn dữ liệu
$sql = "SELECT * FROM users";
$result = mysqli_query($connect, $sql);

// Đảm bảo có dữ liệu
$posts_user = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts_user[] = $row;
    }
}

// Đóng kết nối
// mysqli_close($connect);
?>
