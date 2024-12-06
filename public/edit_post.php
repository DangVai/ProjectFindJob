<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
} else {
    header('Location: ../public/history.php');
    exit;
}

$query = "SELECT * FROM post WHERE id_post = ?";
$stmt = $conn->prepare($query);

// Kiểm tra nếu câu lệnh chuẩn bị thành công
if ($stmt === false) {
    echo "Lỗi khi chuẩn bị câu lệnh SQL: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Bài viết không tồn tại.";
    exit;
}

// Xử lý khi form được gửi (update bài viết)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    $role = $_POST['role'];
    $field = $_POST['field'];
    $priceFrom = $_POST['priceFrom'];
    $goi_dang_ky = $_POST['goi'];
    $location = $_POST['location'];

    // Xử lý ảnh upload
    if ($_FILES['postImage']['name']) {
        $targetDir = '../controllers/uploadss/';
        $imageName = basename($_FILES['postImage']['name']);
        $targetFilePath = $targetDir . $imageName;

        // Kiểm tra và di chuyển ảnh vào thư mục đích
        if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetFilePath)) {
            $image = $imageName; // Lưu tên tệp vào cơ sở dữ liệu
            echo "Ảnh đã được tải lên thành công.";
        } else {
            echo "Lỗi tải ảnh.";
            $image = $post['anh_cong_viec']; // Giữ ảnh cũ nếu không tải lên được
        }
    } else {
        $image = $post['anh_cong_viec']; // Giữ lại ảnh cũ nếu không tải lên ảnh mới
    }

    $updateQuery = "UPDATE post SET title = ?, role = ?, price = ?, linh_vuc = ?, noi_dung = ?, dia_chi = ?, anh_cong_viec = ?, goi_dang_ky = ? WHERE id_post = ?";
    $updateStmt = $conn->prepare($updateQuery);

    // Kiểm tra nếu câu lệnh chuẩn bị thành công
    if ($updateStmt === false) {
        echo "Lỗi khi chuẩn bị câu lệnh SQL: " . $conn->error;
        exit;
    }

    // Bind các tham số cho câu truy vấn
    $updateStmt->bind_param("ssssssssi", $postTitle, $role, $priceFrom, $field, $postContent, $location, $image, $goi_dang_ky, $postId);

    $updateStmt->execute();

    // Kiểm tra nếu cập nhật thành công
    if ($updateStmt->affected_rows > 0) {
        echo "Cập nhật bài viết thành công.";
    } else {
        echo "Không có thay đổi.";
    }
    header("Location: /index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cssfile/edit_post.css">
</head>
<body>
    <div class="container mt-5">
        <form action="../public/edit_post.php?id=<?php echo $postId; ?>" method="POST" enctype="multipart/form-data">
            <h2>Edit Post</h2>
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="postTitle" name="postTitle" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="postContent" class="form-label">Post Content</label>
                <textarea class="form-control" id="postContent" name="postContent" rows="5" required><?php echo htmlspecialchars($post['noi_dung']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="Worker" <?php if ($post['role'] == 'Worker') echo 'selected'; ?>>Worker</option>
                    <option value="Employer" <?php if ($post['role'] == 'Employer') echo 'selected'; ?>>Employer</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="field" class="form-label">Field</label>
                <select class="form-select" id="field" name="field" required>
                    <option value="Gardener" <?php if ($post['linh_vuc'] == 'Gardener') echo 'selected'; ?>>Gardener</option>
                    <option value="Cleaner" <?php if ($post['linh_vuc'] == 'Cleaner') echo 'selected'; ?>>Cleaner</option>
                    <option value="Mover" <?php if ($post['linh_vuc'] == 'Mover') echo 'selected'; ?>>Mover</option>
                    <option value="Driver" <?php if ($post['linh_vuc'] == 'Driver') echo 'selected'; ?>>Driver</option>
                    <option value="Nanny" <?php if ($post['linh_vuc'] == 'Nanny') echo 'selected'; ?>>Nanny</option>
                    <option value="Plantcare" <?php if ($post['linh_vuc'] == 'Plantcare') echo 'selected'; ?>>Plant Care</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="priceFrom" class="form-label">Price</label>
                <input type="number" class="form-control" id="priceFrom" name="priceFrom" value="<?php echo $post['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="goi" class="form-label">Chọn gói</label>
                <select class="form-select" id="goi" name="goi" required>
                    <option value="basic" <?php if ($post['goi_dang_ky'] == 'basic') echo 'selected'; ?>>Basic</option>
                    <option value="premium" <?php if ($post['goi_dang_ky'] == 'premium') echo 'selected'; ?>>Premium</option>
                    <option value="vip" <?php if ($post['goi_dang_ky'] == 'vip') echo 'selected'; ?>>Vip</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" id="location" name="location" required>
                    <option value="Son Tra" <?php if ($post['dia_chi'] == 'Son Tra') echo 'selected'; ?>>Son Tra</option>
                    <option value="Cam Le" <?php if ($post['dia_chi'] == 'Cam Le') echo 'selected'; ?>>Cam Le</option>
                    <option value="Hoa Vang" <?php if ($post['dia_chi'] == 'Hoa Vang') echo 'selected'; ?>>Hoa Vang</option>
                    <option value="Ngu Hanh Son" <?php if ($post['dia_chi'] == 'Ngu Hanh Son') echo 'selected'; ?>>Ngu Hanh Son</option>
                    <option value="Lien Chieu" <?php if ($post['dia_chi'] == 'Lien Chieu') echo 'selected'; ?>>Lien Chieu</option>
                    <option value="Thanh Khue" <?php if ($post['dia_chi'] == 'Thanh Khue') echo 'selected'; ?>>Thanh Khue</option>
                    <option value="Hai Chau" <?php if ($post['dia_chi'] == 'Hai Chau') echo 'selected'; ?>>Hai Chau</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="postImage" class="form-label">Upload Image</label>
                <input class="form-control" type="file" id="postImage" name="postImage">
                <small>Hiện tại ảnh: <img src="../controllers/uploadss/<?php echo $post['anh_cong_viec']; ?>" width="100" alt="Current Image"></small>
            </div>

            <button type="submit" class="btn btn-primary">Update post</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
