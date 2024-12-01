<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu khớp
    if ($new_password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Mã hóa mật khẩu trước khi lưu (sử dụng password_hash)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'mydatabase');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Cập nhật mật khẩu trong cơ sở dữ liệu
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Password has been reset successfully!";
        header("Location: ../public/login.php?message=Password reset successfully");
        exit;

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>