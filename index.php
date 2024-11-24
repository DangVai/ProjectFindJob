<?php
// Kết nối với cơ sở dữ liệu
require_once("config/db.php");

// Truy vấn tất cả các bài đăng
$sql = "SELECT id_post, role, price, linh_vuc, thoi_gian, anh_cong_viec, goi_dang_ky FROM post";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Lấy tất cả kết quả bài đăng
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Trang Chủ</title>
    
</head>
<body>

    <h1>Danh Sách Bài Đăng</h1>
    <a href=""><i class="fa-solid fa-bell"></i></a>
    <?php if ($posts): ?>
        <table border="1">
            <thead>
                <tr>
                    <!-- <th>Name</th> -->
                    <th>Role</th>
                    <th>Price</th>
                    <th>Lĩnh Vực</th>
                    <th>Thời Gian</th>
                    <th>Ảnh Công Việc</th>
                    <th>Gói Đăng Ký</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <!-- <td><?php echo htmlspecialchars($post['name']); ?></td> -->
                        <td><?php echo htmlspecialchars($post['role']); ?></td>
                        <td><?php echo htmlspecialchars($post['price']); ?> VND</td>
                        <td><?php echo htmlspecialchars($post['linh_vuc']); ?></td>
                        <td><?php echo htmlspecialchars($post['thoi_gian']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($post['anh_cong_viec']); ?>" alt="Ảnh Công Việc" style="width: 100px; height: auto;">
                        </td>
                        <td><?php echo htmlspecialchars($post['goi_dang_ky']); ?></td>
                        <td>
                        <td><a href="public/details_job.php?id_post=<?php echo $post['id_post']; ?>">Xem Chi Tiết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có bài đăng nào.</p>
    <?php endif; ?>

</body>
</html>
