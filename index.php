<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user'])) {
    header("Location: public/login.php");
    exit();
}
// Lấy thông tin từ session
$userName = $_SESSION['user']['name'];
$userEmail = $_SESSION['user']['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome</h1>
    <h1>Welcome, <?php echo htmlspecialchars($userName);?>!</h1>
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
    <p>Your email: <?php echo htmlspecialchars($userEmail); ?></p>
    <a href="controllers/logout.php">Log out</a>

    <div class="container">
        <h2 class="text-center">Thêm Dữ Liệu Mới</h2>
        <form action="../models/Post.php" method="POST" enctype="multipart/form-data">
            <label for="content">Nội dung:</label>
            <textarea name="content" required></textarea>

            <label for="address">Địa chỉ:</label>
            <input type="text" name="address">

            <label for="image">Hình ảnh:</label>
            <input type="file" name="image" accept="image/*">

            <label for="salary">Mức lương:</label>
            <input type="number" step="0.01" name="salary">

            <label for="health_request">Yêu cầu sức khỏe:</label>
            <textarea name="health_request"></textarea>

            <button type="submit">Thêm Dữ Liệu</button>
        </form>
    </div>
</body>

</html>