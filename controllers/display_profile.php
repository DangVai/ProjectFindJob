<?php
try {
    // Cấu hình kết nối cơ sở dữ liệu
    include './config/db.php';

    // Kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn danh sách bài viết và thông tin người dùng
    $sql = "
        SELECT post.*, users.fullname, profile.link_anh
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

    // Thực thi truy vấn và lấy kết quả
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý dữ liệu bài viết
    foreach ($posts as $post) {
        // Lấy ảnh đại diện từ bảng profile
        $avatarPath = !empty($post['link_anh']) ? htmlspecialchars($post['link_anh']) : './uploads/default_avatar.png';

        // Lấy tên người dùng
        $nameUser = htmlspecialchars($post['fullname']);
        
        // Bạn có thể sử dụng biến $avatarPath và $nameUser trong vòng lặp để hiển thị thông tin người dùng và bài viết
    }

} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu hoặc truy vấn: " . $e->getMessage());
}
?>
