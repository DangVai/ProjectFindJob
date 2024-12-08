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
    <title>Notification Panel</title>
</head>
<body>
    <div class="notification-panel">
        <h2>Thông báo của bạn</h2>
        <?php if (empty($notifications)): ?>
            <p>Không có thông báo nào.</p>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
            <div class="notification-item">
                <a href="./viewProfile.php"><img src="<?php echo htmlspecialchars($notification['link_anh'] ?? 'default_avatar.jpg'); ?>" 
                     alt="User Avatar" 
                     class="avatar"></a>
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
                        <input type="hidden" name="id_post" value="<?php echo $notification['id_post']; ?>"> <!-- ID bài đăng -->
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
