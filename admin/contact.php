<?php
// Kết nối đến cơ sở dữ liệu
require_once("../config/db.php");

// Truy vấn dữ liệu từ bảng 'contact'
$sql = "SELECT * FROM contact_messages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Liên Hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<style>
 .containers {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 80%;
    margin-top: 40px;
    margin-left: 250px;
}
</style>
</head>

<body>
  <div class="container">
    <?php include_once "./header.php"; ?>
</div>
<div>
    <?php include_once "./sider.php"; ?>
</div>
    <div class="containers">
        <h1>Danh Sách Liên Hệ</h1>

        <?php
        // Kiểm tra xem có kết quả không
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Contact ID</th><th>Username</th><th>Email</th><th>Message</th><th>Created At</th></tr>';

            // Lặp qua từng dòng kết quả và hiển thị
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["contact_id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
            }

            echo '</table>';
        } else {
            echo '<div class="message">Không có dữ liệu.</div>';
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </div>

</body>

</html>