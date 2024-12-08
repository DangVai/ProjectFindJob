<?php
require_once("../config/db.php");
session_start();

// Kiểm tra xem có ID bài đăng không
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    try {
    $sql ="
    SELECT 
    p.id_post, p.role, p.price, p.linh_vuc, p.noi_dung, 
    p.dia_chi, p.thoi_gian, p.anh_cong_viec, p.goi_dang_ky, 
    pr.link_anh, p.title, u.phone, u.username, u.user_id
FROM 
    post p
JOIN 
    users u ON p.user_id = u.user_id
LEFT JOIN 
    profile pr ON p.user_id = pr.user_id
WHERE 
    p.id_post = ?

    ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . mysqli_error($conn));
        }
        $stmt->bind_param('i', $postId); 
        $stmt->execute();

        // Lấy kết quả bài đăng
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            $avatarPath = !empty($post['link_anh']) ? $post['link_anh'] : 'path/to/default_avatar.png';
            $jobImagePath = !empty($post['anh_cong_viec']) ? '../controllers/uploadss/' . $post['anh_cong_viec'] : 'path/to/default_job_image.png';
        } else {
            die("Không tìm thấy bài đăng. Vui lòng kiểm tra lại URL.");
        }
    } catch (Exception $e) {
        die("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
    }
} else {
    die("Không có id bài viết. Vui lòng cung cấp ID bài viết trên URL.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Bài Đăng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/details_job.css">
    <link rel="stylesheet" href="../cssfile/fix-header.css">
    <link rel="stylesheet" href="../cssfile/footer.css">
</head>
<body>
<div class="header">
    <div class="box_logo">
        <img src="../img/anh-weblogo.png" alt="">
    </div>
    <div class="nav">
        <p><b><a href="../index.php">Home</a></b></p>
        <p><b>About Us</b></p>
        <p><b>Contact</b></p>
    </div>
    <div class="chatbox">
        <a href="public/chat.php"><i class="fa-regular fa-comment-dots"></i></a>
    </div>
    <div class="inform">
        <i class="fa-regular fa-bell"></i>
    </div>
    <div class="account">
        <div class="box-account">
            <i class="fa-regular fa-user"></i>
        </div>
    </div>
    <div class="name-user">
            <div class="dropdown-menu" id="account-menu">
                <div>
                    <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                </div>
                <div>
                    <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
                </div>
                <div>
                    <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
                </div>
                <div>
                    <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
                </div>
                <div>
                    <a href="index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="rounded-circle" width="80" height="80">
                    <p class="mt-2"><strong><?php echo htmlspecialchars($post['username']); ?></strong></p>
                </div>
                <div class="col-md-10">
                    <div class="item">
                    <p><strong>Tiêu đề:</strong> <?php echo htmlspecialchars($post['title']); ?></p>
                    <p><strong>Nội Dung:</strong> <?php echo nl2br(htmlspecialchars($post['noi_dung'])); ?></p>
                    <p><strong>Vai trò:</strong> <?php echo htmlspecialchars($post['role']); ?></p>
                    <p><strong>Lĩnh Vực:</strong> <?php echo htmlspecialchars($post['linh_vuc']); ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($post['phone']); ?></p>
                    <p><strong>Giá:</strong> <?php echo htmlspecialchars($post['price']); ?> VND</p>
                    <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($post['dia_chi']); ?></p>
                    <p><strong>Gói Đăng Ký:</strong> <?php echo htmlspecialchars($post['goi_dang_ky']); ?></p>
                    <p><strong>Thời Gian Đăng:</strong> <?php echo htmlspecialchars($post['thoi_gian']); ?></p>
                    </div>
                    <div class="mt-3">
                        <img src="<?php echo htmlspecialchars($jobImagePath); ?>" alt="Hình Ảnh Công Việc" class="img-fluid" />
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
            <?php if ($_SESSION['user_id'] !== $post['user_id']): ?> <!-- Kiểm tra nếu người đăng nhập khác người đăng bài -->
                <form action="../controllers/receive_job.php" method="POST">
                    <input type="hidden" name="id_post" value="<?php echo htmlspecialchars($post['id_post']); ?>">
                    <input type="hidden" name="job_title" value="<?php echo htmlspecialchars($post['title']); ?>">
                    <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($post['user_id']); ?>">
                    <button type="submit" class="btn btn-primary">
                        Nhận Công Việc
                    </button>
                </form>
                <?php else: ?>
                <!-- Thông báo không thể nhận công việc của chính mình -->
                <div class="alert alert-info" role="alert">
                     <!-- Bạn là người đăng bài này. Không thể nhận công việc -->
                </div>
            <?php endif; ?>
            <button class="btn btn-primary">
                <a href="../public/chat.php" class="text-white"><i class="fas fa-comment-alt" style="font-size: 20px"></i></a>
            </button>
        </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>