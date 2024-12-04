<?php
require_once '../config/db.php';
require_once '../controllers/getProfileData.php';

$conn = new mysqli('localhost', 'root', '', 'mydatabase');
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$userData = getUserProfile($userId, $conn);
if (!$userData) {
    echo "Không tìm thấy người dùng.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ của <?php echo htmlspecialchars($userData['fullname']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/userView.css">
</head>
<body>
<div class="container">
    <h1><i class="fas fa-user"></i> Hồ sơ của <?php echo htmlspecialchars($userData['fullname']); ?></h1>

    <!-- Grid Bố Cục -->
    <div class="grid-container">
        <!-- Thông tin người dùng -->
        <div class="info">
            <h2><i class="fas fa-info-circle"></i> Thông tin</h2>
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            <p><i class="fas fa-phone"></i> <strong>Điện thoại:</strong> <?php echo htmlspecialchars($userData['phone']); ?></p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($userData['address']); ?></p>
            <p><i class="fas fa-venus-mars"></i> <strong>Giới tính:</strong> <?php echo htmlspecialchars($userData['gender']); ?></p>
            <p><i class="fas fa-birthday-cake"></i> <strong>Ngày sinh:</strong> <?php echo htmlspecialchars($userData['birthday']); ?></p>
       

        <!-- Nút "Viết đánh giá" -->
        <button class="btn btn-primary" id="writeReviewBtn">Viết đánh giá</button>

        <!-- Form đánh giá -->
        <div class="review-form-overlay" id="reviewForm" style="display: none;">
            <div class="review-form">
                <span class="close-btn" id="closeReviewForm">&times;</span>
                <h3><i class="fas fa-pencil-alt"></i> Viết đánh giá</h3>
                <form method="POST" action="../controllers/saveReview.php">
                    <input type="hidden" name="rated_user_id" value="<?php echo htmlspecialchars($userId); ?>">

                    <div class="stars">
                        <input type="radio" name="soSao" id="star1" value="1" required>
                        <label class="star" for="star1">&#9733;</label>
                        <input type="radio" name="soSao" id="star2" value="2">
                        <label class="star" for="star2">&#9733;</label>
                        <input type="radio" name="soSao" id="star3" value="3">
                        <label class="star" for="star3">&#9733;</label>
                        <input type="radio" name="soSao" id="star4" value="4">
                        <label class="star" for="star4">&#9733;</label>
                        <input type="radio" name="soSao" id="star5" value="5">
                        <label class="star" for="star5">&#9733;</label>
                    </div>
                    <textarea name="content" placeholder="Nội dung đánh giá..." required></textarea>
                    <button type="submit"><i class="fas fa-paper-plane"></i> Gửi Đánh Giá</button>
                </form>
            </div>
        </div>
 </div>
       <!-- Đánh giá -->
<div class="reviews">
    <h2><i class="fas fa-comments"></i> Đánh giá</h2>
    <?php foreach ($userData['reviews'] as $review): ?>
        <div class="review">
            <strong><?php echo htmlspecialchars($review['reviewer_name']); ?></strong>
            <p>
                <i class="fas fa-star"></i> Số sao: <?php echo htmlspecialchars($review['soSao']); ?>
            </p>
            <p><?php echo htmlspecialchars($review['content']); ?></p>
        </div>
    <?php endforeach; ?>
</div>

    </div>

    <!-- Bài viết -->
    <div class="posts-container">
        <h2><i class="fas fa-pen"></i> Bài viết</h2>
        <?php foreach ($userData['posts'] as $post): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['role']); ?></h3>
                <p><?php echo htmlspecialchars($post['noi_dung']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="../jsfile/rating.js"></script>
</body>
</html>
