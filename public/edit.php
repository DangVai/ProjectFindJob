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
    <link rel="stylesheet" href="../cssfile/fix-header.css">
    <link rel="stylesheet" href="../cssfile/footer.css">
</head>
<body>
<div class="header">
    <div class="box_logo">
        <img src="img/anh-weblogo.png" alt="">
    </div>
    <div class="nav">
        <p><b>Home</b></p>
        <p><b>About Us</b></p>
        <p><b>Contact</b></p>
    </div>
    <div class="chatbox">
        <a href="public/chat.php"><i class="fa-regular fa-comment-dots"></i></a>
    </div>
    <div class="inform">
        <i class="fa-regular fa-bell"></i>
    </div>
    <div class="account">
        <div class="box-account">
            <i class="fa-regular fa-user"></i>
        </div>
    </div>
    <div class="name-user">
        <div class="dropdown-menu" id="account-menu">
            <div>
                <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
            </div>
            <div>
                <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
            </div>
            <div>
                <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
            </div>
            <div>
                <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
            </div>
            <div>
                <a href="controllers/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
            </div>
        </div>
    </div>
</div>
  <div class="container-fluid d-flex flex-column justify-content-start align-items-center" style="margin-top:80px; margin-bottom:50px;">
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
<?php
require_once '../footer.php';
?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
