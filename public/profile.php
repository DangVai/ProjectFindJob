<?php
include '../controllers/profile_data.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../cssfile/profile.css">
  <link rel="stylesheet" href="../cssfile/fix-header.css">
  <link rel="stylesheet" href="../cssfile/footer.css">
</head>

<body>
  <div class="container-fluid" style="text-align: center;">
    <div class="header">
      <div class="box_logo">
        <img src="../img/anh-weblogo.png" alt="">
      </div>
      <div class="nav">
        <p><b><a href="../index.php">Home</a></b></p>
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
            <a href="index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center w-100" style="margin-top: 100px">
      <h1 class="mb-3 pt-5 text-black text-center">Your Profile</h1>
    </div>

    <div class="container profile-container-bluid mt-4" style="text-align: center">
      <div class="row justify-content-center">
        <!-- Profile Menu Column -->
        <div class="col-md-3 profile-menu">
          <img src="<?php echo htmlspecialchars($link_anh); ?>" alt="Profile Image"
            class="profile-image img-fluid rounded-circle mb-3">
          <div class="menu">
            <a href="profile.php">Information</a>
            <a href="edit.php">Edit Profile</a>
            <div class="settings-dropdown">
              <a>Settings</a>
              <div class="dropdown-options">
                <a href="./edit_post.php">Manage Posts</a>
                <a href="#" class="change-password-link">Change Password</a>
                <a href="#" class="text-danger">Delete Account</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Info Column -->
        <div class="col-md-5 profile-info">
          <div class="info-box">
            <p><i class="fas fa-user"></i> <strong>Full Name:</strong> <?php echo htmlspecialchars($fullname); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-user-tag"></i> <strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-lock"></i> <strong>Password:</strong> <em>********</em> (not displayed)</p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-phone"></i> <strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-venus-mars"></i> <strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-birthday-cake"></i> <strong>Date of Birth:</strong>
              <?php echo htmlspecialchars($birthday); ?></p>
          </div>
          <div class="info-box">
            <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <?php echo htmlspecialchars($address); ?>
            </p>
          </div>


        </div>

        <!-- Review Table Column -->
        <div class="col-md-4 reviews" style="height: 800px; overflow-y: auto;">
          <h2><i class="fas fa-comments"></i> Reviews</h2>
          <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
              <div class="review">
                <strong><?php echo htmlspecialchars($review['reviewer_name']); ?></strong>
                <p>
                  <i class="fas fa-star"></i> Rating: <?php echo htmlspecialchars($review['soSao']); ?>
                </p>
                <p><?php echo htmlspecialchars($review['content']); ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No reviews available.</p>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal Change Password -->
  <div id="changePasswordModal" class="mk" style="display: none;">

    <div class="mk-content">
      <span class="close-btn">&times;</span>
      <h2>Change Password</h2>
      <form action="../controllers/changePassword.php" method="POST">
        <div class="form-group">
          <label for="oldPassword">Old Password:</label>
          <input type="password" id="oldPassword" name="old_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="newPassword">New Password:</label>
          <input type="password" id="newPassword" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm New Password:</label>
          <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Change Password</button>
        <button type="button" id="cancelChangeBtn" class="btn btn-secondary">Cancel</button>
      </form>
    </div>
  </div>

  <!-- Modal Warning for Deleting Account -->
  <div id="deleteAccountModal" class="xoa" style="display: none;">
    <div class="xoa-content">
      <span class="close-btn">&times;</span>
      <h2 class="text-danger">Warning: Delete Account</h2>
      <p>Once you delete your account, all your data will be lost and cannot be restored.</p>
      <form action="../controllers/deleteAccount.php" method="POST">
        <button type="button" id="cancelDeleteBtn" class="btn btn-secondary">Cancel</button>
        <button type="submit" name="confirm_delete" class="btn btn-danger">Delete Account</button>
      </form>
    </div>

  </div>
  <?php
  require_once '../footer.php';
  ?>

  <script src="../jsfile/profile.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>