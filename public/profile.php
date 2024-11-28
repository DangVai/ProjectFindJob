
<?php
session_start();
require_once '../config/db.php';

$conn = mysqli_connect("localhost", "root", "", "hand&foot");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

// Kiểm tra user_id có trong session
$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ bảng users
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Khởi tạo các biến để tránh cảnh báo
$fullname = $username = $email = $phone = null;
$address = $gender = $birthdate = $link_anh = null;

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullname = $user['fullname'] ?? 'Chưa cập nhật';
    $username = $user['username'] ?? 'Chưa cập nhật';
    $email = $user['email'] ?? 'Chưa cập nhật';
    $phone = $user['phone'] ?? 'Chưa cập nhật';
} else {
    echo "Không tìm thấy người dùng.";
}

$stmt->close();
// Lấy thông tin từ bảng profile
$sql_profile = "SELECT link_anh, gender, birthday, address FROM profile WHERE user_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("i", $user_id);
$stmt_profile->execute();
$result_profile = $stmt_profile->get_result();

if ($result_profile->num_rows > 0) {
    $profile = $result_profile->fetch_assoc();
    $link_anh = $profile['link_anh'] ?? 'https://via.placeholder.com/150';
    $address = $profile['address'] ?? 'Chưa cập nhật';
    $gender = $profile['gender'] ?? 'Chưa cập nhật';
    $birthdate = $profile['birthday'] ?? 'Chưa cập nhật'; // Cập nhật ngày sinh
} else {
    $link_anh = 'https://via.placeholder.com/150';
}

$stmt_profile->close();

// Lấy đánh giá
$sql_review = "SELECT * FROM preview WHERE user_id = ?";
$stmt_review = $conn->prepare($sql_review);
$stmt_review->bind_param("i", $user_id);
$stmt_review->execute();
$result_review = $stmt_review->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Người Dùng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../cssfile/profile.css">

</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Hồ Sơ Của Bạn</h1>
        <div class="profile-container">
            
            <div class="profile-menu">
                <img src="<?php echo htmlspecialchars($link_anh); ?>" alt="Ảnh đại diện" class="profile-image">
                <div class="memu">
                    <a href="profile.php">Thông tin cá nhân</a>
                    <a href="edit.php">Chỉnh sửa hồ sơ</a>
                    <a href="settings.php">Cài đặt</a>
                    <a href="feedback.php">Phản hồi</a>
                </div>
            </div>
            <div class="profile-info">
                <div class="info-box">
                    <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($fullname); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Tên Đăng Nhập:</strong> <?php echo htmlspecialchars($username); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Mật Khẩu:</strong> <em>********</em> (không hiển thị)</p>
                </div>
                <div class="info-box">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Giới Tính:</strong> <?php echo htmlspecialchars($gender); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($birthdate); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($address); ?></p>
                </div>
                <div class="info-box">
                    <h3>Đánh giá</h3>
                    <div class="review-table" style="max-height: 200px; overflow-y: auto;">
                        <?php if ($result_review->num_rows > 0) {
                            echo '<table class="table table-striped">';
                            echo '<thead><tr><th>ID</th><th>Người Dùng</th><th>Số Sao</th><th>Nội Dung</th></tr></thead>';
                            echo '<tbody>';
                            while ($row = $result_review->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['preview_id'] . '</td>';
                                echo '<td>' . $row['user_id'] . '</td>';
                                echo '<td>' . $row['soSao'] . '</td>';
                                echo '<td>' . $row['content'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>Chưa có đánh giá nào.</p>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>