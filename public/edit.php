<?php
include '../controllers/edit_data.php';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Hồ Sơ</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cssfile/edit.css">
</head>
<body>
  <div class="container-fluid d-flex flex-column justify-content-start align-items-center">
    <!-- Phần Tiêu Đề -->
    <div class="text-center w-100">
    <h1 class="mb-3 pt-4 text-black">Edit Profile</h1>
    </div>

    <!-- Profile Container -->
    <div class="profile-container-bluid w-75 bg-white bg-opacity-75 rounded p-4 mt-4" style="border-radius:20px ;background-color:#8dfe9c;box-shadow: 0 10px 6px rgba(0, 0, 0, 0.1);">
      <div class="row gx-5">
        <!-- Profile Edit Form Column -->
        <div class="col-md-8 col-lg-9">
        <form method="post" action="../controllers/edit_data.php" enctype="multipart/form-data" style="margin-left: 145px;">
    <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
    </div>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <select class="form-control" id="gender" name="gender">
            <option value="Male" <?php echo ($gender == 'Nam') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Nữ') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($gender == 'Khác') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="birthday">Birthday:</label>
        <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>">
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
    </div>
    <div class="form-group">
        <label for="profile_image">Profile Image:</label>
        <input type="file" class="form-control-file" id="profile_image" name="profile_image">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="profile.php" class="btn btn-secondary">Back to Profile</a>
</form>

        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
