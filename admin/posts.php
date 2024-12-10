<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .container {
      position: relative;
      z-index: 1;
    }

    .sidebar {
      margin-top: 200px;
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
    <table>
      <thead>
        <tr>
          <th>user_id</th>
          <th>Full Name</th>
          <th>Phone</th>
          <th>id_post</th>
          <th>Role</th>
          <th>Field</th>
          <th>Address</th>
          <th>Price</th>
          <th>Created</th>
          <th>Type</th>
          <th>Image</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "
          SELECT 
              u.user_id, 
              u.fullname, 
              u.phone,
              p.id_post, 
              p.role, 
              p.linh_vuc, 
              p.dia_chi, 
              p.price, 
              p.thoi_gian, 
              p.goi_dang_ky,
              p.anh_cong_viec,
              p.confirm_status
          FROM 
              post p
          JOIN 
              users u 
          ON 
              p.user_id = u.user_id
          ORDER BY 
              p.user_id ASC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Ép kiểu các giá trị cần thiết
            $row['id_post'] = intval($row['id_post']);
            $row['user_id'] = intval($row['user_id']);
            
            echo '<tr id="row-' . htmlspecialchars($row['id_post']) . '">
              <td>' . htmlspecialchars($row['user_id']) . '</td>
              <td>' . htmlspecialchars($row['fullname']) . '</td>
              <td>' . htmlspecialchars($row['phone']) . '</td>
              <td>' . htmlspecialchars($row['id_post']) . '</td>
              <td>' . htmlspecialchars($row['role']) . '</td>
              <td>' . htmlspecialchars($row['linh_vuc']) . '</td>
              <td>' . htmlspecialchars($row['dia_chi']) . '</td>
              <td>' . htmlspecialchars($row['price']) . '</td>
              <td>' . date("M d, Y", strtotime($row['thoi_gian'])) . '</td>
              <td>' . htmlspecialchars($row['goi_dang_ky']) . '</td>
              <td>
                  <img src="../controllers/uploadss/' . htmlspecialchars($row['anh_cong_viec']) . '" alt="Image" style="width: 50px; height: 50px;">
              </td>';
            // Hiển thị trạng thái
            if ($row['confirm_status'] == 0) {
              echo '<td style="background-color: yellow">Chờ</td>';
            } elseif ($row['confirm_status'] == 1) {
              echo '<td style="background-color: green">Đã duyệt</td>';
            } elseif ($row['confirm_status'] == 2) {
              echo '<td style="background-color: red">Từ chối</td>';
            }
            // Nút hành động
            echo '<td>
                      <button class="button small green" onclick="window.location.href=\'../public/details_job.php?id=' . $row['id_post'] . '\';">View</button>
                      <button class="button small red" onclick="deleteRow(' . $row['id_post'] . ')">Delete</button>
                  </td>
              </tr>';
          }
        } else {
          echo "<tr><td colspan='13'>No data available</td></tr>";
        }

        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  function deleteRow(id_post) {
    if (!confirm("Are you sure you want to delete this post?")) {
        return;
    }
    fetch('delete/delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_post=${id_post}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok " + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            if (data.trim() === "success") {
                const row = document.getElementById(`row-${id_post}`);
                if (row) row.remove();
                alert("Post deleted successfully!");
            } else {
                alert("Error deleting post: " + data);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Failed to delete. Please try again later.");
        });
}
</script>

</html>
