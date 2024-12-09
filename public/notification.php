<?php
session_start();
require_once("../config/db.php");

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Kiểm tra user_id trong session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<p>Vui lòng đăng nhập để xem thông báo.</p>";
    exit();
}

$receiver_id = $_SESSION['user_id'];
$query = "
    SELECT 
        n.id AS notification_id, 
        n.sender_id, 
        n.message, 
        n.created_at, 
        n.id_post,  -- Thêm cột id_post
        u.username, 
        p.link_anh 
    FROM 
        notifications n 
    JOIN 
        users u ON n.sender_id = u.user_id 
    LEFT JOIN 
        profile p ON u.user_id = p.user_id 
    WHERE 
        n.receiver_id = ? 
    ORDER BY 
        n.created_at DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Chuẩn bị truy vấn thất bại: " . $conn->error);
}

$stmt->bind_param('i', $receiver_id);
if (!$stmt->execute()) {
    die("Thực thi truy vấn thất bại: " . $stmt->error);
}

$result = $stmt->get_result();

$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../cssfile/notification.css">
    <link rel="stylesheet" href="../cssfile/fix-header.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cssfile/footer.css">
    <title>Notification Panel</title>
</head>
    <!-- <div class="header">
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
                    <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile</a>
                </div>
                <div>
                    <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
                </div>
                <div>
                    <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
                </div>
                <div>
                    <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log
                        in</a>
                </div>
                <div>
                    <a href="index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
                </div>
            </div>
        </div>
    </div> -->

    <div class="notification-panel">
        <h2>Thông báo của bạn</h2>
        <?php if (empty($notifications)): ?>
            <p>Không có thông báo nào.</p>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item">
                    <a href="./viewProfile.php"><img
                            src="<?php echo htmlspecialchars($notification['link_anh'] ?? 'default_avatar.jpg'); ?>"
                            alt="User Avatar" class="avatar"></a>
                    <p class="mt-2"><strong><?php echo htmlspecialchars($notification['username']); ?></strong></p>
                    <div class="notification-content">
                        <p>
                            <?php
                            echo $notification['message'];
                            ?>
                        </p>
                        <span class="timestamp"><?php echo htmlspecialchars($notification['created_at']); ?></span>
                    </div>

                    <!-- Kiểm tra nếu là người đăng bài -->
                    <?php if ($notification['sender_id'] !== $_SESSION['user_id']): ?>
                        <form method="POST" action="../controllers/handle_response.php">
                            <input type="hidden" name="notification_id" value="<?php echo $notification['notification_id']; ?>">
                            <input type="hidden" name="sender_id" value="<?php echo $notification['sender_id']; ?>">
                            <input type="hidden" name="id_post" value="<?php echo $notification['id_post']; ?>">
                            <!-- ID bài đăng -->
                            <input type="hidden" name="is_owner" value="true">
                            <button type="submit" name="accept" class="action-btn">✔️</button>
                            <button type="submit" name="decline" class="action-btn">❌</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>


    </body>

</html>