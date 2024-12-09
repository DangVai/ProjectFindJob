<?php
try {
    // Cấu hình kết nối cơ sở dữ liệu
    include './config/db.php';

    // Kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Xác định limit và offset (phân trang)
    $limit = 10; // Bạn có thể thay đổi giá trị này
    $offset = 0; // Giá trị offset cho trang hiện tại, ví dụ: 0 cho trang đầu tiên

    // Truy vấn danh sách bài viết và thông tin người dùng
    $sql = "
        SELECT post.*, users.fullname, profile.link_anh
        FROM post
        JOIN users ON post.user_id = users.user_id
        JOIN profile ON users.user_id = profile.user_id
        WHERE post.confirm_status = 1
        ORDER BY 
            -- Ưu tiên bài viết có gói đăng ký 'vip', 'premium', 'basic'
            CASE 
                WHEN post.goi_dang_ky = 'vip' THEN 1 
                WHEN post.goi_dang_ky = 'premium' THEN 2 
                WHEN post.goi_dang_ky = 'basic' THEN 3 
                ELSE 4 
            END,
            -- Nếu bài viết có cùng gói thì sắp xếp theo thời gian đăng (bài viết mới hơn xuất hiện trước)
            post.thoi_gian DESC 
        LIMIT :limit OFFSET :offset
    ";

    // Thực thi truy vấn với tham số limit và offset
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu hoặc truy vấn: " . $e->getMessage());
}
?>
