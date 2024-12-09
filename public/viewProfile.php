<?php
require_once '../config/db.php';
require_once '../controllers/getProfileData.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$userData = getUserProfile($userId, $conn);
if (!$userData) {
    echo "User not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile of <?php echo htmlspecialchars($userData['fullname']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cssfile/userView.css">
    <link rel="stylesheet" href="../cssfile/fix-header.css">
    <link rel="stylesheet" href="../cssfile/footer.css">
</head>
<body>
<div class="container">
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
    <h1><i class="fas fa-user"></i> Profile of <?php echo htmlspecialchars($userData['fullname']); ?></h1>
    <img src="<?php echo htmlspecialchars($userData['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail" width="150">
    <!-- Grid Layout -->
    <div class="grid-container">
        <!-- User Information -->
        <div class="info">
            <h2><i class="fas fa-info-circle"></i> Information</h2>
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            <p><i class="fas fa-phone"></i> <strong>Phone:</strong> <?php echo htmlspecialchars($userData['phone']); ?></p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <?php echo htmlspecialchars($userData['address']); ?></p>
            <p><i class="fas fa-venus-mars"></i> <strong>Gender:</strong> <?php echo htmlspecialchars($userData['gender']); ?></p>
            <p><i class="fas fa-birthday-cake"></i> <strong>Birthday:</strong> <?php echo htmlspecialchars($userData['birthday']); ?></p>
        
        <!-- "Write a Review" Button -->
        <button class="btn btn-primary" id="writeReviewBtn">Write a Review</button>

        <!-- Review Form -->
        <div class="review-form-overlay" id="reviewForm" style="display: none;">
            <div class="review-form">
                <span class="close-btn" id="closeReviewForm">&times;</span>
                <h3><i class="fas fa-pencil-alt"></i> Write a Review</h3>
            <form method="POST" action="../controllers/saveReview.php">
                <input type="hidden" name="rated_user_id" value="<?php echo $userId; ?>">
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
                <textarea name="content" placeholder="Review content..." required></textarea>
                <button type="submit"><i class="fas fa-paper-plane"></i> Submit Review</button>
        </form>

            </div>
        </div>
 </div>
       <!-- Reviews -->
        <div class="reviews">
            <h2><i class="fas fa-comments"></i> Reviews</h2>
            <?php if (!empty($userData['reviews'])): ?>
                <?php foreach ($userData['reviews'] as $review): ?>
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

    <!-- Posts -->
    <div class="posts-container">
        <h2><i class="fas fa-pen"></i> Posts</h2>
        <?php foreach ($userData['posts'] as $post): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['role']); ?></h3>
                <p><?php echo htmlspecialchars($post['noi_dung']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php 
    require_once '../footer.php';
    ?>

<script src="../jsfile/rating.js"></script>
</body>
</html>
