<?php
session_start();

require_once '../config/db.php';

$conn = mysqli_connect("localhost", "root", "1234", "mydatabase");

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

    $sql_check_profile = "SELECT id FROM profile WHERE user_id = ?";
    $stmt_check = $conn->prepare($sql_check_profile);
    $stmt_check->bind_param('i', $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Nếu đã tồn tại bản ghi, thực hiện UPDATE
        $sql_update_profile = "UPDATE profile SET link_anh = ?, gender = ?, birthday = ?, address = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update_profile);
        $stmt_update->bind_param('ssssi', $link_anh, $gender, $birthday, $address, $user_id);
    } else {
        // Nếu chưa tồn tại bản ghi, thực hiện INSERT
        $sql_insert_profile = "INSERT INTO profile (user_id, link_anh, gender, birthday, address) VALUES (?, ?, ?, ?, ?)";
        $stmt_update = $conn->prepare($sql_insert_profile);
        $stmt_update->bind_param('issss', $user_id, $link_anh, $gender, $birthday, $address);
    }

    $stmt_update->execute();

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
