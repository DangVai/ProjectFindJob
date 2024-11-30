<?php
session_start();

if (isset($_SESSION['username'])) {
    $userName = $_SESSION['username'];
} else {
    $userName = "Guest"; // Giá trị mặc định nếu không có session
}
?>
<?php
require '../config/db.php';

// Lấy thông tin user_id từ session
$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

// Xác định số lượng thông báo mỗi trang
$limit = 10; // Lấy 10 thông báo mỗi lần
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Lấy trang hiện tại từ URL
$offset = ($page - 1) * $limit; // Tính toán offset để lấy đúng dữ liệu

// Truy vấn để lấy thông báo
$notifications = $conn->query("
    SELECT notifications.id, post.noi_dung AS title, users.fullname AS name, notifications.created_at 
    FROM notifications
    JOIN post ON notifications.id_post = post.id_post
    JOIN users ON notifications.user_id = users.user_id
    WHERE notifications.is_read = 0 AND notifications.user_id = $userId
    ORDER BY notifications.created_at DESC
    LIMIT $limit OFFSET $offset
");

// Kiểm tra lỗi truy vấn
if ($notifications === false) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Đếm tổng số thông báo để tính số trang
$total_notifications = $conn->query("
    SELECT COUNT(*) AS total 
    FROM notifications 
    WHERE is_read = 0 AND user_id = $userId
")->fetch_assoc();
$total_pages = ceil($total_notifications['total'] / $limit);

////////////////////////////////////////////
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu hoặc truy vấn: " . $e->getMessage());
}
////////////////////////////////////////////
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các bài đã đăng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQW5Pkn9kyjOLkc7Hj6PaTO3HWStjLpWXhj9KC7snr1fZMMe9E6e46lg/" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
        }

        .badge.vip {
            background-color: #ffc107;
        }

        .badge.premium {
            background-color: #17a2b8;
        }

        .badge.basic {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <h2>Danh sách các bài đã đăng</h2>
    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Tên người dùng</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Lĩnh vực</th>
                <th>Giá</th>
                <th>Địa chỉ</th>
                <th>Loại gói</th>
                <th>Số điện thoại</th>
                <th>Thời gian</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <?php
            // Lấy đường dẫn ảnh đại diện từ bảng profile
            $avatarPath = !empty($post['link_anh']) ? $post['link_anh'] : 'path/to/default_avatar.png';
            ?>
            <tr>
                <td>
                    <img src="<?php echo "../public" . htmlspecialchars($avatarPath); ?>" alt="Avatar" width="50" height="50" class="rounded-circle">
                </td>
                <td><?php echo htmlspecialchars($post['fullname']); ?></td>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars($post['noi_dung']); ?></td>
                <td><?php echo htmlspecialchars($post['linh_vuc']); ?></td>
                <td><?php echo htmlspecialchars($post['price']); ?></td>
                <td><?php echo htmlspecialchars($post['dia_chi']); ?></td>
                <td>
                    <span class="badge <?php echo htmlspecialchars($post['goi_dang_ky']); ?>">
                        <?php echo ucfirst($post['goi_dang_ky']); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($post['phone']); ?></td>
                <td><?php echo htmlspecialchars($post['thoi_gian']); ?></td>

                
                <!-- Thêm nút chỉnh sửa và xóa -->
                <td>
                    <a href="edit_post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                    <a href="delete_post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10" class="text-center">Không có bài viết nào phù hợp.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</body>
</html>
