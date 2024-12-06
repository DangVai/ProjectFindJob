<?php
// Kết nối cơ sở dữ liệu (sử dụng MySQLi thay cho PDO)
require_once("../config/db.php");

// Kiểm tra xem có 'id' trong URL hay không
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    try {
        // Truy vấn SQL để lấy thông tin bài đăng
        $sql = "
        SELECT 
            p.id_post, p.role, p.price, p.linh_vuc, p.noi_dung, 
            p.dia_chi, p.thoi_gian, p.anh_cong_viec, p.goi_dang_ky, 
            pr.link_anh, u.username
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
            die("Lỗi chuẩn bị câu truy vấn: " . mysqli_error($conn)); // Dùng mysqli_error thay vì errorInfo
        }

        // Gắn tham số vào câu truy vấn
        $stmt->bind_param('i', $postId); // 'i' chỉ định kiểu dữ liệu integer
        $stmt->execute();

        // Lấy kết quả bài đăng
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            $avatarPath = !empty($post['link_anh']) ? $post['link_anh'] : 'path/to/default_avatar.png';
            $jobImagePath = !empty($post['anh_cong_viec']) ? $post['anh_cong_viec'] : 'path/to/default_job_image.png';

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
    <!-- CSS Framework -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/details_job.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="row">
                <!-- Avatar và tên người đăng -->
                <div class="col-md-2 text-center">
                    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="rounded-circle"
                        width="80" height="80">
                    <p class="mt-2"><strong><?php echo htmlspecialchars($post['username']); ?></strong></p>
                </div>
                <!-- Thông tin chi tiết bài đăng -->
                <div class="col-md-10">
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($post['role']); ?></p>
                    <p><strong>Price:</strong> <?php echo htmlspecialchars($post['price']); ?> VND</p>
                    <p><strong>Lĩnh Vực:</strong> <?php echo htmlspecialchars($post['linh_vuc']); ?></p>
                    <p><strong>Nội Dung:</strong> <?php echo nl2br(htmlspecialchars($post['noi_dung'])); ?></p>
                    <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($post['dia_chi']); ?></p>
                    <p><strong>Thời Gian Đăng:</strong> <?php echo htmlspecialchars($post['thoi_gian']); ?></p>
                    <p><strong>Gói Đăng Ký:</strong> <?php echo htmlspecialchars($post['goi_dang_ky']); ?></p>
                    <!-- Hình ảnh bài đăng -->
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'&& $_GET['action'] === 'edit_post.php') {
                            // Xử lý khi đang chỉnh sửa bài viết
                            echo '
                            <div class="mt-3">
                                <img src="/public/'. htmlspecialchars($jobImagePath) . '" alt="Hình Ảnh Công Việc" class="img-fluid" />
                            </div>';
                        } else {
                            // Xử lý khi đăng bài mới
                            echo '
                            <div class="mt-3">
                                <img src="../controllers/uploadss/'. htmlspecialchars($jobImagePath) . '" alt="Hình Ảnh Công Việc" class="img-fluid" />
                            </div>';
                        }
                    ?>



                </div>
            </div>
            <!-- Nút Nhận Công Việc và Chat -->
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-success" type="button" data-bs-toggle="modal"
                    data-bs-target="#confirmationModal">
                    Nhận Công Việc
                </button>
                <button class="btn btn-primary">
                    <!-- <i class="fas fa-comment-alt" style="font-size: 20px"></i> -->
                    <a href="../public/chat.php"><i class="fas fa-comment-alt" style="font-size: 20px"></i></a>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận -->
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
                    <form id="acceptJobForm" action="../controllers/receive_job.php" method="POST">
                        <input type="hidden" name="id_post" value="<?php echo $post['id_post']; ?>">
                        <button class="btn btn-success" type="submit" name="receive_job">Chấp Nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>