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

// Xác định số lượng bài đăng mỗi trang
$limit = 10; // Lấy 10 bài đăng mỗi lần
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Lấy trang hiện tại từ URL
$offset = ($page - 1) * $limit; // Tính toán offset để lấy đúng dữ liệu

// Truy vấn để lấy các bài đăng của người dùng hiện tại
$sql = "
    SELECT *
    FROM post
    JOIN users ON post.user_id = users.user_id
    JOIN profile ON users.user_id = profile.user_id
    WHERE post.confirm_status = 1 AND post.user_id = $userId
    ORDER BY 
        CASE 
            WHEN post.goi_dang_ky = 'vip' THEN 1 
            WHEN post.goi_dang_ky = 'premium' THEN 2 
            WHEN post.goi_dang_ky = 'basic' THEN 3 
            ELSE 4 
        END,
        post.thoi_gian DESC
    LIMIT $limit OFFSET $offset
";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu hoặc truy vấn: " . $e->getMessage());
}

// Đếm tổng số bài đăng của người dùng để tính số trang
$total_posts = $conn->query("
    SELECT COUNT(*) AS total 
    FROM post 
    WHERE confirm_status = 1 AND user_id = $userId
")->fetch(PDO::FETCH_ASSOC);
$total_pages = ceil($total_posts['total'] / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Posted Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQW5Pkn9kyjOLkc7Hj6PaTO3HWStjLpWXhj9KC7snr1fZMMe9E6e46lg/" crossorigin="anonymous">
    <link rel="stylesheet" href="../cssfile/history.css">
</head>

<body>
    <h2>List of Posted Articles</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Username</th>
                <th>Title</th>
                <th>Content</th>
                <th>Field</th>
                <th>Price</th>
                <th>Address</th>
                <th>Package Type</th>
                <th>Phone Number</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <?php
                    // Get the avatar path from the profile table
                    $avatarPath = !empty($post['link_anh']) ? $post['link_anh'] : 'path/to/default_avatar.png';
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" width="50" height="50"
                                class="rounded-circle">
                        </td>
                        <td><?php echo htmlspecialchars($post['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td class="content_post"
                            style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo htmlspecialchars($post['noi_dung']); ?>
                        </td>

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

                        <!-- Add edit and delete buttons -->
                        <td>
                            <a href="edit_post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this post?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">No posts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>
