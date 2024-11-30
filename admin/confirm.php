<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
      <link rel="stylesheet" href="cssheader/confirm.css">
  <style>
    .container {
      position: relative;
      z-index: 1;
    }
    .sidebar {
      margin-top: 250px;
      position: relative;
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
  <div id="main-content" class="p-4 p-md-5 pt-5">
    <?php
    if (isset($_GET['id']) && isset($_GET['status'])) {
      $id = $_GET['id'];
      $status = $_GET['status'];
    
      // Cập nhật trạng thái bài viết
      $sqlUpdate = "UPDATE post SET confirm_status = $status WHERE id_post = $id";

      if ($conn->query($sqlUpdate) === TRUE) {
        if ($status == 1) {
          echo "<p class='success-message'>Bài viết đã được duyệt!</p>";
        } else {
          echo "<p class='error-message'>Bài viết đã bị từ chối!</p>";
        }
      } else {
        echo "<p class='error-message'>Lỗi: " . $conn->error . "</p>";
      }
    }

    $sql = "SELECT * FROM post WHERE confirm_status = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo '<div class="post-list">';
      while ($row = $result->fetch_assoc()) {
        echo "<div class='post-item'>";
        echo "<h3 class='post-title'>" . $row["role"] . "</h3>";
        echo "<p class='post-content'>" . $row['noi_dung'] . "</p>";
        echo "<p class='post-info'><b>By:</b> " . $row['user_id'] . " | <b>Time:</b> " . $row['thoi_gian'] . "</p>";
        echo "<p><b>Salary:</b> " . $row['price'] . " | <b>Field:</b> " . $row['linh_vuc'] . "</p>";
        echo "<p><b>Location:</b> " . $row['dia_chi'] . "</p>";
        echo "<img src='../images/" . $row['anh_cong_viec'] . "' alt='Image' width='100'>";
        echo "<p><b>Subscription Plan:</b> " . $row['goi_dang_ky'] . "</p>";
        echo "<div class='post-actions'>";
        echo "<a class='button approve' href='?id=" . $row['id_post'] . "&status=1'>Duyệt bài</a> | ";
        echo "<a class='button reject' href='?id=" . $row['id_post'] . "&status=2'>Từ chối bài</a>";
        echo "</div>";
        echo "</div><hr>";
      }
      echo '</div>';
    } else {
      echo "<p class='no-posts'>Không có bài viết nào chờ duyệt!</p>";
    }

    $conn->close();
    ?>
  </div>
</body>
</html>