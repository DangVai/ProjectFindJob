
<?php
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
;
?>