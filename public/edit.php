<?php
session_start();

require_once '../config/db.php';

$conn = mysqli_connect("localhost", "root", "", "hand&foot");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql_user = "SELECT * FROM users WHERE user_id=?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, 'i', $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);

if (!$user) {
    echo "Không tìm thấy người dùng.";
    exit();
}

// Lấy thông tin người dùng
$fullname = $user['fullname'] ?? '';
$username = $user['username'] ?? '';
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';
$link_anh = 'https://via.placeholder.com/150.png?text=No+Image'; // Giá trị mặc định cho ảnh đại diện

// Lấy thông tin từ bảng profile
$sql_profile = "SELECT link_anh, gender, birthday, address FROM profile WHERE user_id=?";
$stmt_profile = mysqli_prepare($conn, $sql_profile);
mysqli_stmt_bind_param($stmt_profile, 'i', $user_id);
mysqli_stmt_execute($stmt_profile);
$result_profile = mysqli_stmt_get_result($stmt_profile);
$profile = mysqli_fetch_assoc($result_profile);

if ($profile) {
    $link_anh = $profile['link_anh'] ?? $link_anh;
    $address = $profile['address'] ?? '';
    $gender = $profile['gender'] ?? ''; // Cập nhật giới tính
    $birthday = $profile['birthday'] ?? ''; // Cập nhật ngày sinh
} else {
    $address = '';
    $gender = '';
    $birthday = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];

    // Xử lý tải ảnh lên
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['profile_image'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image["name"]);

        // Kiểm tra nếu thư mục uploads không tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
         $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowed_types)) {
            echo "Chỉ cho phép tải lên ảnh JPG, PNG hoặc GIF.";
            exit();
        }

        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $link_anh = $target_file;
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi tải ảnh lên.</div>";
        }
    }


    // Cập nhật thông tin người dùng
    $sql_update_users = "UPDATE users SET fullname=?, username=?, email=?, phone=? WHERE user_id=?";
    $stmt_users = mysqli_prepare($conn, $sql_update_users);
    mysqli_stmt_bind_param($stmt_users, 'ssssi', $fullname, $username, $email, $phone, $user_id);
    mysqli_stmt_execute($stmt_users);

    // Cập nhật thông tin profile
 $sql_update_profile = "INSERT INTO profile (user_id, link_anh, gender, birthday,address) VALUES (?, ?, ?, ?, ?)
                       ON DUPLICATE KEY UPDATE link_anh=?, gender=?, birthday=?, address=?";
$stmt_profile = mysqli_prepare($conn, $sql_update_profile);
mysqli_stmt_bind_param($stmt_profile, 'issssssss', $user_id, $link_anh, $gender, $birthday, $address, $link_anh, $gender, $birthday, $address);
mysqli_stmt_execute($stmt_profile);

    // Cập nhật thông tin trong session
    $_SESSION['user']['fullname'] = $fullname;
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['link_anh'] = $link_anh;
    $_SESSION['user']['address'] = $address;

    header("Location: ../public/profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Hồ Sơ</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../cssfile/edit.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Chỉnh Sửa Hồ Sơ</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullname">Họ và Tên:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Tên Đăng Nhập:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            </div>
            <div class="form-group">
            <label for="gender">Giới Tính:</label>
            <select class="form-control" id="gender" name="gender">
                <option value="Nam" <?php echo ($gender == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo ($gender == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                <option value="Khác" <?php echo ($gender == 'Khác') ? 'selected' : ''; ?>>Khác</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birthday">Ngày Sinh:</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>">
        </div>
            <div class="form-group">
                <label for="address">Địa Chỉ:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Ảnh Đại Diện:</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
            <img src="<?php echo htmlspecialchars($link_anh); ?>" alt="Ảnh đại diện" class="profile-image">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="profile.php" class="btn btn-secondary">Quay Lại Hồ Sơ</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>