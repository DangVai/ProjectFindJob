
<?php
include '../controllers/profile_data.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Người Dùng</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../cssfile/profile.css">

</head>
<body>
<div class="container-fluid" style="text-align: center;">

  <div class="text-center w-100">
   
    <h1 class="mb-3 pt-5 text-black">Hồ Sơ Của Bạn</h1>
  </div>

  
  <div class="container profile-container-bluid mt-4" style="text-align: center">
    <div class="row justify-content-center" >
      <!-- Profile Menu Column -->
      <div class="col-md-3 profile-menu">
        <img src="<?php echo htmlspecialchars($link_anh); ?>" alt="Ảnh đại diện" class="profile-image img-fluid rounded-circle mb-3">
        <div class="menu">
          <a href="profile.php" >Thông tin</a>
          <a href="edit.php" >Sửa hồ sơ</a>
          <div class="settings-dropdown">
            <a >Cài đặt</a>
            <div class="dropdown-options">
              <a href="edit_post.php" >Quản lý bài đăng</a>
              <a href="#" class="change-password-link">Đổi mật khẩu</a>
              <a href="#" class="text-danger">Xóa tài khoản</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Info Column -->
      <div class="col-md-5 profile-info">
        <div class="info-box">
  <p><i class="fas fa-user"></i> <strong>Họ và Tên:</strong> <?php echo htmlspecialchars($fullname); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-user-tag"></i> <strong>Tên Đăng Nhập:</strong> <?php echo htmlspecialchars($username); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-lock"></i> <strong>Mật Khẩu:</strong> <em>********</em> (không hiển thị)</p>
</div>
<div class="info-box">
  <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-phone"></i> <strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-venus-mars"></i> <strong>Giới Tính:</strong> <?php echo htmlspecialchars($gender); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-birthday-cake"></i> <strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($birthday); ?></p>
</div>
<div class="info-box">
  <p><i class="fas fa-map-marker-alt"></i> <strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($address); ?></p>
</div>

      </div>

      <!-- Review Table Column -->
      <div class="col-md-4">
        <div class="info-box">
          <h3>Đánh giá</h3>
          <div class="review-table" style="max-height: 300px; overflow-y: auto;">
            <?php if ($result_review->num_rows > 0) {
              echo '<table class="table table-striped">';
              echo '<thead><tr><th>ID</th><th>Số Sao</th><th>Nội Dung</th></tr></thead>';
              echo '<tbody>';
              while ($row = $result_review->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['preview_id'] . '</td>';
                echo '<td>' . $row['soSao'] . '</td>';
                echo '<td>' . $row['content'] . '</td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              echo '<p>Chưa có đánh giá nào.</p>';
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal đổi mật khẩu -->
<div id="changePasswordModal" class="mk" style="display: none;">
    <div class="mk-content">
        <span class="close-btn">&times;</span>
        <h2>Đổi Mật Khẩu</h2>
        <form action="../controllers/changePassword.php" method="POST">
            <div class="form-group">
                <label for="oldPassword">Mật khẩu cũ:</label>
                <input type="password" id="oldPassword" name="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Mật khẩu mới:</label>
                <input type="password" id="newPassword" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Nhập lại mật khẩu mới:</label>
                <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Đổi mật khẩu</button>
            <button type="button" id="cancelChangeBtn" class="btn btn-secondary">Hủy</button>
        </form>
    </div>
</div>





<!-- Modal cảnh báo xóa tài khoản -->
<div id="deleteAccountModal" class="xoa" style="display: none;">
    <div class="xoa-content">
        <span class="close-btn">&times;</span>
        <h2 class="text-danger">Cảnh cáo: Xóa tài khoản</h2>
        <p>Khi xóa tài khoản, bạn sẽ mất toàn bộ dữ liệu và không thể khôi phục.</p>
        <form action="../controllers/deleteAccount.php" method="POST">
            <button type="button" id="cancelDeleteBtn" class="btn btn-secondary">Hủy</button>
            <button type="submit" name="confirm_delete" class="btn btn-danger">Xóa tài khoản</button>
        </form>
    </div>
</div>
<script src="../jsfile/profile.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>