<?php
session_start();
include '../config/db.php'; // Kết nối tới database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp']);

    // Lấy email hoặc thông tin từ session (đã lưu khi đăng ký)
    if (!isset($_SESSION['email'])) {
        die("Session expired. Please try registering again.");
    }

    $email = $_SESSION['email'];

    // Kiểm tra mã OTP trong bảng pending_users
    $stmt = $conn->prepare("SELECT otp, otp_created_at FROM pending_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra OTP có khớp không
        if ($otp == $user['otp']) {
            // Kiểm tra thời hạn của OTP (giả sử 15 phút)
            $otp_created_at = strtotime($user['otp_created_at']);
            $current_time = time();

            if (($current_time - $otp_created_at) <=180) {
                // OTP hợp lệ, chuyển user từ pending_users sang users
                $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, phone, password) 
                                        SELECT fullname, username, email, phone, password FROM pending_users WHERE email = ?");
                $stmt->bind_param("s", $email);
                if ($stmt->execute()) {
                    // Xóa user khỏi bảng pending_users
                    $stmt = $conn->prepare("DELETE FROM pending_users WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    
                    header("Location: ../public/login.php?success=account_verified");
                    exit;
                } else {
                    header("Location: ../public/register.php?error=account_verification_failed");
                    exit;
                }
            } else {
                header("Location: ../public/register.php?error=expired");
                exit;
            }
        } else {
            header("Location: ../public/register.php?error=Invalids");
            exit;
        }
    } else {
        header("Location: ../public/register.php?error=No_pending");
        exit;
    }
}
