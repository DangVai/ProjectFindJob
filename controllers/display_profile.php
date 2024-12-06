<?php
require_once "models/Post2.php";

// Chuẩn bị dữ liệu các bài viết
foreach ($posts as $post): 
    $sql1 = "
        SELECT 
            profile.link_anh
        FROM profile
        WHERE user_id = :user_id
        ";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(':user_id', $post['user_id'], PDO::PARAM_INT);
    $stmt1->execute();
    $link_anh = $stmt1->fetch(PDO::FETCH_ASSOC);

    $avatarPath = !empty($link_anh['link_anh']) ? htmlspecialchars($link_anh['link_anh']) : './uploads/default_avatar.png';
    $nameUser = "";

    foreach ($posts_user as $user) {
        if ($user["user_id"] == $post["user_id"]) {
            $nameUser = $user["fullname"];
            break;
        }
    }
?>
<div class="post" data-address="<?php echo htmlspecialchars($post['dia_chi']); ?>" 
     data-field="<?php echo htmlspecialchars($post['linh_vuc']); ?>">
    <div class="card-profile">
        <div class="avatar">
            <a href="public/viewProfile.php?user_id=<?php echo $post['user_id']; ?>">
                <img src="<?php echo $avatarPath; ?>" alt="Avatar" class="rounded-circle" width="80" height="80">
            </a>
        </div>
        <div class="name">
            <a href="public/viewProfile.php?user_id=<?php echo $post['user_id']; ?>">
                <p style="color: #000"><?php echo !empty($nameUser) ? htmlspecialchars($nameUser) : ""; ?></p>
            </a>
        </div>
    </div>
    <div class="card-content">
        <div class="title-content">
            <h3><?php echo htmlspecialchars($post["linh_vuc"]); ?></h3>
            <div class="package"><?php echo htmlspecialchars($post["goi_dang_ky"]); ?></div>
            <p class="time-post"><?php echo htmlspecialchars($post["thoi_gian"]); ?></p>
        </div>
        <div class="main-content">
            <p><b>Price: </b><?php echo htmlspecialchars($post["price"]); ?></p>
            <p><b>Address:</b> <?php echo htmlspecialchars($post["dia_chi"]); ?></p>
            <p class="content-post"><b>Content:</b> <?php echo htmlspecialchars($post["noi_dung"]); ?></p>
        </div>
    </div>
    <button class="btn-link show-more-btn">
        <a href="./public/details_job.php?id=<?php echo htmlspecialchars($post['id_post']); ?>">Xem chi tiết</a>
    </button>
</div>
<?php endforeach; ?>
