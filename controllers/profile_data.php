<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['message']) && $_GET['message'] === 'success') {
    $success_message = "Đã cập nhật thành công!";
}

$conn = mysqli_connect("localhost", "root", "", "mydatabase");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    if ($message === 'success') {
        echo '<div class="alert alert-success">Cập nhật thành công!</div>';
    } elseif ($message === 'error_wrong_password') {
        echo '<div class="alert alert-danger">Mật khẩu cũ không đúng!</div>';
    } elseif ($message === 'error_password_mismatch') {
        echo '<div class="alert alert-danger">Mật khẩu mới không khớp!</div>';
    } elseif ($message === 'account_deleted') {
        echo '<div class="alert alert-success">Tài khoản đã được xóa!</div>';
    }
}


// Lấy thông tin người dùng từ bảng users
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$fullname = $username = $email = $phone = null;
$address = $gender = $birthdate = $link_anh = null;
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullname = $user['fullname'] ?? 'Chưa cập nhật';
    $username = $user['username'] ?? 'Chưa cập nhật';
    $email = $user['email'] ?? 'Chưa cập nhật';
    $phone = $user['phone'] ?? 'Chưa cập nhật';
}else {
    echo "Không tìm thấy người dùng.";
}

$stmt->close();

// Lấy thông tin từ bảng profile
$sql_profile = "SELECT link_anh, gender, birthday, address FROM profile WHERE user_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("i", $user_id);
$stmt_profile->execute();
$result_profile = $stmt_profile->get_result();

$link_anh = $address = $gender = $birthday = 'Chưa cập nhật';
if ($result_profile->num_rows > 0) {
    $profile = $result_profile->fetch_assoc();
    $link_anh = $profile['link_anh'] ?? 'https://via.placeholder.com/150';
    $address = $profile['address'] ?? 'Chưa cập nhật';
    $gender = $profile['gender'] ?? 'Chưa cập nhật';
    $birthday = $profile['birthday'] ?? 'Chưa cập nhật';
}else {
    // Thiết lập giá trị mặc định nếu không có bản ghi
    $link_anh = 'https://via.placeholder.com/150';
    $address = 'Chưa cập nhật';
    $gender = 'Chưa cập nhật';
    $birthday = 'Chưa cập nhật';}
$stmt_profile->close();

// Lấy đánh giá và thông tin người đánh giá
$sql_review = "
    SELECT 
        p.soSao, 
        p.content, 
        u.fullname AS reviewer_name
    FROM 
        preview p
    JOIN users u ON p.user_id = u.user_id
    WHERE p.rated_user_id = ?
";
$stmt_review = $conn->prepare($sql_review);
$stmt_review->bind_param("i", $user_id);
$stmt_review->execute();
$result_review = $stmt_review->get_result();

$reviews = [];
while ($row = $result_review->fetch_assoc()) {
    $reviews[] = $row;
}

$stmt_review->close();

?>
