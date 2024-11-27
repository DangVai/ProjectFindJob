<?php require_once "../controllers/send_message.php";
if ($latest_chat && mysqli_num_rows($latest_chat) > 0) {
    $last_message = mysqli_fetch_assoc($latest_chat);
    echo "Tin nhắn mới nhất từ " . htmlspecialchars($last_message['sender_name']) . ": ";
    echo htmlspecialchars($last_message['message']);
} else {
    echo "Không có tin nhắn nào.";
}

?>

<!-- Sidebar Danh sách người dùng -->
<div class="col-md-4 col-xl-3 chat">
    <div class="card mb-sm-3 mb-md-0 contacts_card">
        <div class="card-header">
            <div class="input-group">
                <input type="text" placeholder="Search..." class="form-control search">
                <div class="input-group-prepend">
                    <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
        <div class="card-body contacts_body">
            
            <ul class="contacts">
                <?php $id = 28; while ($user = mysqli_fetch_assoc($users)): ?>
                    <?php if ($user['user_id'] == $id): // Kiểm tra ID của người dùng ?>
                            <a href="chat.php?receiver_id=<?php echo $user['user_id']; ?>">

                        <span><?php echo htmlspecialchars($user['fullname']); ?></span>
                        
                    <?php endif; ?>
                <?php endwhile; ?>

            </ul>
        </div>
    </div>
</div>