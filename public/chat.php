<?php
require_once "../controllers/send_message.php";
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="../cssfile/chat.css">
</head>

<body>
    <a href="../index.php" class="back">back</a>

    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <!-- Sidebar Danh sách người dùng -->
            <div class="col-md-4 col-xl-3 chat">
                <div class="card mb-sm-3 mb-md-0 contacts_card">
                    <div class="card-header">
                        <form method="POST" class="input-group">
                            <input type="text" name="search" 
                                   value="" placeholder="Search..."
                                class="form-control search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body contacts_body">
                        <ul class="contacts">
                            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                <li>
                                    <a href="?receiver_id=<?php echo $user['user_id']; ?>">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="https://designs.vn/wp-content/images/30-07-2015/chup-anh-nguoi-xa-la-1_resize.jpg"
                                                    class="rounded-circle user_img">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span><?php echo htmlspecialchars($user['fullname']); ?></span>
                                                <p style="font-size: 15px;">
                                                    <?php
                                                        $stmt = mysqli_prepare($conn, $sql_latest_chat);
                                                        mysqli_stmt_bind_param($stmt, "iiii", $userId, $user['user_id'], $user['user_id'], $userId);
                                                        mysqli_stmt_execute($stmt);
                                                        $latest_chat = mysqli_stmt_get_result($stmt);

                                                        if ($latest_chat && mysqli_num_rows($latest_chat) > 0) {
                                                            $last_message = mysqli_fetch_assoc($latest_chat);
                                                            echo htmlspecialchars($last_message['message']);
                                                        } else {
                                                            echo "Chưa có tin nhắn.";
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Chat Box -->
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="https://png.pngtree.com/png-vector/20240305/ourlarge/pngtree-handsome-man-with-his-arms-crossed-over-white-background-png-image_11887195.png"
                                    class="rounded-circle user_img">
                                <span class="online_icon"></span>
                            </div>
                            <div class="user_info">
                                <?php if (isset($receiver_name)): ?>
                                    <span>Chat với <?php echo htmlspecialchars($receiver_name); ?></span>
                                <?php else: ?>
                                    <span>Chọn người dùng để bắt đầu chat</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body msg_card_body">
                        <?php if (isset($chats)): ?>
                            <?php while ($chat = mysqli_fetch_assoc($chats)): ?>
                                <div
                                    class="d-flex <?php echo $chat['sender_id'] == $userId ? 'justify-content-end' : 'justify-content-start'; ?> mb-4">
                                    <div class="msg_cotainer<?php echo $chat['sender_id'] == $userId ? '_send' : ''; ?>">
                                        <strong><?php echo $chat['sender_id'] == $userId ? 'Bạn' : htmlspecialchars($receiver_name); ?></strong>
                                        <?php echo htmlspecialchars($chat['message']); ?>
                                        <span class="msg_time<?php echo $chat['sender_id'] == $userId ? '_send' : ''; ?>">
                                            <?php echo $chat['sent_at']; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center text-muted">Chọn người dùng để bắt đầu cuộc trò chuyện.</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <form method="POST" class="input-group">
                            <input type="hidden" name="receiver_id"
                                value="<?php echo htmlspecialchars($receiver_id ?? ''); ?>">
                            <input name="message" class="form-control" placeholder="Nhập tin nhắn..."></input>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary send_btn"><i
                                        class="fas fa-location-arrow"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>