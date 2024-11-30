<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            position: relative; /* Đảm bảo vị trí của container là cơ sở */
            z-index: 1; /* Đảm bảo container ở trên */
        }

        .sidebar {
            margin-top: 200px; /* Tạo khoảng cách 200px dưới container */
            position: relative; /* Có thể tùy chỉnh vị trí nếu cần */
        }

    </style>
</head>
<body>
    <div class="container">
        <?php include_once "header.php" ?>
    </div>
    <div>
        <?php include_once "sider.php" ?>
    </div>
    <div id="main-content" class="p-4 p-md-5 pt-5">
        <div>
            <h1>Số người dùng đăng ký tháng này</h1>
            <?php
            $sql = "SELECT 
                YEAR(created_at) AS year,
                MONTH(created_at) AS month,
                COUNT(user_id) AS total_users
            FROM 
                users
            WHERE 
                created_at IS NOT NULL
            GROUP BY 
                YEAR(created_at), MONTH(created_at)
            ORDER BY 
                YEAR(created_at) ASC, MONTH(created_at) ASC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Hiển thị kết quả
                echo "<table border='1'>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Users</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['year'] . "</td>
                    <td>" . $row['month'] . "</td>
                    <td>" . $row['total_users'] . "</td>
                </tr>";
                }

                echo "</table>";
            } else {
                echo "0 results";
            }
            ?>
        </div>
        <h1>Số người đăng bài từng ngày</h1>
        <?php
        $sql = "SELECT 
            DATE(thoi_gian) AS day,
            COUNT(thoi_gian) AS total_posts
        FROM 
            post
        WHERE 
            thoi_gian IS NOT NULL
        GROUP BY 
            DATE(thoi_gian)
        ORDER BY 
            DATE(thoi_gian) ASC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hiển thị kết quả
            echo "<table border='1'>
        <tr>
            <th>Ngày</th>
            <th>Tổng số bài đăng</th>
        </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
            <td>" . $row['day'] . "</td>
            <td>" . $row['total_posts'] . "</td>
        </tr>";
            }

            echo "</table>";
        } else {
            echo "Không có kết quả.";
        }

        // Đóng kết nối
        $conn->close();
        ?>

    </div>
    
</body>
</html>