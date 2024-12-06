<?php
// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
require_once("../config/db.php");


try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// Hàm xử lý tải ảnh lên
function handleFileUpload($file) {
    $targetDir = "uploadss/"; // Sửa tên thư mục
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
            die("Không thể tạo thư mục tải ảnh.");
        }
    }

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($file['tmp_name']);
        if (strpos($fileType, 'image') === false) {
            die("Chỉ cho phép tải lên ảnh.");
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            die("Ảnh tải lên không được vượt quá 5MB.");
        }

        $fileName = uniqid() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        } else {
            die("Không thể lưu file trên server.");
        }
    } else {
        die("Lỗi khi tải ảnh lên: " . $file['error']);
    }
}

// Hàm lấy bài viết
function getPosts($filter = 'all') {
    global $conn;

    $sql = "SELECT * FROM post WHERE confirm_status = 1";

    if ($filter === 'vip') {
        $sql .= " AND goi_dang_ky = 'vip'";
    } elseif ($filter === 'premium') {
        $sql .= " AND goi_dang_ky = 'premium'";
    } elseif ($filter === 'basic') {
        $sql .= " AND goi_dang_ky = 'basic'";
    }

    $sql .= " ORDER BY 
        CASE 
            WHEN goi_dang_ky = 'vip' THEN 1
            WHEN goi_dang_ky = 'premium' THEN 2
            WHEN goi_dang_ky = 'basic' THEN 3
            ELSE 4
        END,
        thoi_gian DESC";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Lỗi truy vấn: " . $e->getMessage());
    }
}

// Xử lý khi người dùng gửi bài viết
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Bạn cần đăng nhập trước khi đăng bài.");
    }

    $postContent = $_POST['postContent'] ?? null;
    $role = $_POST['role'] ?? null;
    $field = $_POST['field'] ?? null;
    $priceFrom = $_POST['priceFrom'] ?? null;
    $goi = $_POST['goi'] ?? null;
    $location = $_POST['location'] ?? null;
    $postTitle = $_POST['postTitle'] ?? null;

    if (!$postContent || !$role || !$field || !$priceFrom || !$goi || !$location || !$postTitle) {
        die("Vui lòng điền đầy đủ thông tin bắt buộc.");
    }

    $imagePath = '';
    if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] === UPLOAD_ERR_OK) {
        $imagePath = handleFileUpload($_FILES['postImage']);
    }

    $thoiGian = date("Y-m-d H:i:s");
    $expireTime = date('Y-m-d H:i:s', strtotime("$thoiGian + 1 minute"));

    try {
        $sql = "INSERT INTO post (user_id, role, price, linh_vuc, noi_dung, dia_chi, anh_cong_viec, goi_dang_ky,title,confirm_status) 
                VALUES (:userId, :role, :priceFrom, :field, :postContent, :location, :imagePath, :goi, :postTitle, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userId' => $_SESSION['user_id'],
            ':role' => $role,
            ':priceFrom' => $priceFrom,
            ':field' => $field,
            ':postContent' => $postContent,
            ':location' => $location,
            ':imagePath' => $imagePath,
            ':goi' => $goi,
            ':postTitle' => $postTitle,
        ]);

        echo "Bài đăng đã được gửi thành công và đang xử lý!";
        header("Location: /index.php");
        exit;
    } catch (PDOException $e) {
        die("Lỗi truy vấn: " . $e->getMessage());
    }
}

// Lấy danh sách bài viết đã duyệt
$posts = getPosts();
header("Location:../index.php");
exit;
?>
