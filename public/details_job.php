<?php
// Kết nối với cơ sở dữ liệu
require_once("../config/db.php");

// Lấy id_post từ URL
$id_post = isset($_GET['id_post']) ? intval($_GET['id_post']) : null;

// Nếu không có id_post, hiển thị lỗi
if (!$id_post) {
    die("Không tìm thấy bài đăng.");
}

try {
    // Truy vấn thông tin bài đăng từ cơ sở dữ liệu (có sửa lại)
    $sql = "
    SELECT p.id_post, p.role, p.price, p.linh_vuc, p.noi_dung, p.dia_chi, p.thoi_gian, p.anh_cong_viec, p.goi_dang_ky, pr.link_anh, u.username
    FROM post p
    JOIN users u ON p.user_id = u.user_id
    LEFT JOIN profile pr ON p.user_id = pr.user_id
    WHERE p.id_post = :id_post
";


    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();


    //////
    // Kiểm tra và lấy thông tin bài đăng
    if ($stmt->rowCount() > 0) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $avatarPath = !empty($post['link_anh']) ? $post['link_anh'] : 'path/to/default_avatar.png'; // Đường dẫn đến ảnh mặc định
        $jobImagePath = !empty($post['anh_cong_viec']) ? $post['anh_cong_viec'] : 'path/to/default_job_image.png'; // Đường dẫn đến ảnh công việc mặc định
    } else {
        die("Không tìm thấy bài đăng.");
    }
} catch (PDOException $e) {
    die("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
}
?>
<!-- ///////////////////////////////////// -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Bài Đăng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cssfile/details_job.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="row">
                <!-- Ảnh đại diện và tên người đăng -->
                <div class="col-md-2 text-center">
                    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="rounded-circle"
                        width="80" height="80">
                    <p class="mt-2"><strong><?php echo htmlspecialchars($post['username']); ?></strong></p>
                </div>
                <!-- Chi tiết bài đăng -->
                <div class="col-md-10">
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($post['role']); ?></p>
                    <p><strong>Price:</strong> <?php echo htmlspecialchars($post['price']); ?> VND</p>
                    <p><strong>Lĩnh Vực:</strong> <?php echo htmlspecialchars($post['linh_vuc']); ?></p>
                    <p><strong>Nội Dung:</strong> <?php echo nl2br(htmlspecialchars($post['noi_dung'])); ?></p>
                    <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($post['dia_chi']); ?></p>
                    <p><strong>Thời Gian Đăng:</strong> <?php echo htmlspecialchars($post['thoi_gian']); ?></p>
                    <p><strong>Gói Đăng Ký:</strong> <?php echo htmlspecialchars($post['goi_dang_ky']); ?></p>
                    <!-- Hiển thị hình ảnh công việc -->
                    <div class="mt-3">
                        <img src="<?php echo htmlspecialchars($jobImagePath); ?>" alt="Hình Ảnh Công Việc"
                            class="img-fluid" />
                    </div>
                </div>
            </div>
            <!-- Các nút Nhận Công Việc và Chat Box -->
            <div class="d-flex justify-content-between">
                <button class="btn btn-success" type="button" data-bs-toggle="modal"
                    data-bs-target="#confirmationModal">
                    Nhận Công Việc
                </button>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">
                    <i class="fas fa-comment-alt" style="font-size: 20px"></i>
                </button>
            </div>
        </div>

        <!-- Modal lựa chọn đồng ý hay từ chối-->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Xác Nhận Nhận Công Việc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn nhận công việc này không?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Từ Chối</button>
                        <!-- <form id="acceptJobForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_post=' . $id_post; ?>" method="POST">
                    <input type="hidden" name="id_post" value="<?php echo $post['id_post']; ?>">
                    <button class="btn btn-success" type="submit" name="receive_job">Chấp Nhận</button>
                </form> -->
                        <form id="acceptJobForm" action="../controllers/receive_job.php" method="POST">
                            <input type="hidden" name="id_post" value="<?php echo $post['id_post']; ?>">
                            <button class="btn btn-success" type="submit" name="receive_job">Chấp Nhận</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>