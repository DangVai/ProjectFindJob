

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Bài Đăng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/fix-header.css">
    <link rel="stylesheet" href="../cssfile/footer.css">
    <style>
        .message-container {
    text-align: center;
    padding: 50px;
    background-color: #fff;
    border: 2px solid #f44336;
    border-radius: 10px;
    width: 600px;
    margin: 0 auto;
}

.icon {
    margin-bottom: 20px;
}

.message-content h2 {
    color: #f44336;
}

.message-content p {
    color: #555;
}

.button-container .btn-close {
    background-color: #f44336;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button-container .btn-close:hover {
    background-color: #d32f2f;
}

    </style>
</head>
<body>
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
        <a href="./chat.php"><i class="fa-regular fa-comment-dots"></i></a>
    </div>
    <div class="inform">
        <a href="./notification.php"><i class="fa-regular fa-bell"></i></a>
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

<div class="message-container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="icon">
        <i class="fa fa-times-circle" style="color: red; font-size: 50px;"></i> <!-- Dấu "X" màu đỏ -->
    </div>
    <div class="message-content">
    <h2>You cannot rate your own post</h2>
    <p>Please go back.</p>
</div>

</div>
<?php include '../footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
