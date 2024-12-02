<?php
include '../controllers/db_connect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Lấy thông tin người dùng
    $sql_user = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Lấy bài đăng của người dùng
    $sql_posts = "SELECT * FROM posts WHERE user_id = ?";
    $stmt = $conn->prepare($sql_posts);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $posts = $stmt->get_result();

    // Lấy đánh giá về người dùng
    $sql_reviews = "SELECT reviews.*, users.username AS reviewer_username 
                    FROM reviews 
                    JOIN users ON reviews.reviewer_id = users.user_id
                    WHERE reviews.user_id = ?";
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $reviews = $stmt->get_result();

    // Xử lý form đánh giá nếu gửi dữ liệu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reviewer_id = $_SESSION['user_id']; // Người đánh giá (người đang đăng nhập)
        $rating = $_POST['rating'];
        $content = $_POST['content'];

        $sql_insert_review = "INSERT INTO reviews (user_id, reviewer_id, rating, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_review);
        $stmt->bind_param("iiis", $user_id, $reviewer_id, $rating, $content);

        if ($stmt->execute()) {
            header("Location: profile.php?user_id=$user_id"); // Tải lại trang để cập nhật danh sách đánh giá
            exit;
        } else {
            $error_message = "Lỗi khi thêm đánh giá: " . $conn->error;
        }
    }
} else {
    echo "Người dùng không tồn tại.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Người Dùng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Hồ Sơ Người Dùng: <?php echo htmlspecialchars($user['fullname']); ?></h1>
    <img src="<?php echo htmlspecialchars($user['avatar']); ?>" class="img-fluid rounded-circle mb-3" alt="Avatar">
    
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
    
    <hr>
    <h3>Bài đăng</h3>
    <ul>
        <?php while ($post = $posts->fetch_assoc()): ?>
            <li><a href="post_detail.php?post_id=<?php echo $post['post_id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></li>
        <?php endwhile; ?>
    </ul>
    
    <hr>
    <h3>Đánh giá</h3>
    <?php if ($reviews->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Số sao</th>
                    <th>Nội dung</th>
                    <th>Người đánh giá</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $reviews->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['rating']); ?></td>
                        <td><?php echo htmlspecialchars($review['content']); ?></td>
                        <td><?php echo htmlspecialchars($review['reviewer_username']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có đánh giá nào.</p>
    <?php endif; ?>

    <!-- Form đánh giá -->
    <hr>
    <h3>Đánh giá người dùng này</h3>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Số sao:</label>
            <select name="rating" class="form-control" required>
                <option value="1">1 Sao</option>
                <option value="2">2 Sao</option>
                <option value="3">3 Sao</option>
                <option value="4">4 Sao</option>
                <option value="5">5 Sao</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nội dung đánh giá:</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
    </form>
</div>
</body>
</html>
