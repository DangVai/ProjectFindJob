<?php
try {
    // Cấu hình kết nối cơ sở dữ liệu
   include './config/db.php';

    // Kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn danh sách bài viết
    $sql = "
    SELECT *
    FROM post
    JOIN users ON post.user_id = users.user_id
    JOIN profile ON users.user_id = profile.user_id
    WHERE post.confirm_status = 1
    ORDER BY 
        CASE 
            WHEN post.goi_dang_ky = 'vip' THEN 1 
            WHEN post.goi_dang_ky = 'premium' THEN 2 
            WHEN post.goi_dang_ky = 'basic' THEN 3 
            ELSE 4 
        END,
        post.thoi_gian DESC
";

} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu hoặc truy vấn: " . $e->getMessage());
}
?>
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