<?php
    session_start();
    require_once '../config/db.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.php");
        exit();
    }

    // Lấy thông tin người dùng từ session
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['username'];

    // Lấy danh sách người dùng khác
    $sql_users = "SELECT user_id, fullname FROM users WHERE user_id != ?";
    $stmt = mysqli_prepare($conn, $sql_users);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $users = mysqli_stmt_get_result($stmt);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $receiver_id = $_POST['receiver_id']; // ID người nhận được lấy từ form
        $message = trim($_POST['message']); // Nội dung tin nhắn

        // Kiểm tra nếu tin nhắn không hợp lệ (rỗng hoặc quá ngắn)
        if (empty($message)) {
            // Thông báo lỗi
            header("Location: " . $_SERVER['PHP_SELF'] . "?receiver_id=" . $receiver_id . "&error=empty_message");
            exit();
        }

        // Lưu tin nhắn vào cơ sở dữ liệu
        $stmt = mysqli_prepare($conn, "INSERT INTO chit_chat (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iis", $userId, $receiver_id, $message);
        mysqli_stmt_execute($stmt);

        // Tải lại trang để tránh gửi lại form
        header("Location: " . $_SERVER['PHP_SELF'] . "?receiver_id=" . $receiver_id);
        exit();
    }


// Lấy tên người nhận
    $receiver_name = '';
    $receiver_id = isset($_GET['receiver_id']) ? (int) $_GET['receiver_id'] : null;

    if ($receiver_id) {
        $stmt = mysqli_prepare($conn, "SELECT fullname FROM users WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $receiver_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $receiver_name = $row['fullname'];
        }
    }

    // Lấy tin nhắn của bạn và người nhận đã chọn
    $sql_chats = "
        SELECT c.*, u.fullname AS sender_name 
        FROM chit_chat c
        JOIN users u ON c.sender_id = u.user_id
        WHERE (c.sender_id = ? AND c.receiver_id = ?) OR (c.sender_id = ? AND c.receiver_id = ?)
        ORDER BY c.sent_at ASC
    ";
    $stmt = mysqli_prepare($conn, $sql_chats);
    mysqli_stmt_bind_param($stmt, "iiii", $userId, $receiver_id, $receiver_id, $userId);
    mysqli_stmt_execute($stmt);
    $chats = mysqli_stmt_get_result($stmt);

    $sql_latest_chat = "
        SELECT c.*, u.fullname AS sender_name 
        FROM chit_chat c
        JOIN users u ON c.sender_id = u.user_id
        WHERE (c.sender_id = ? AND c.receiver_id = ?) OR (c.sender_id = ? AND c.receiver_id = ?)
        ORDER BY c.sent_at DESC
        LIMIT 1
    ";
    $stmt = mysqli_prepare($conn, $sql_latest_chat);
    mysqli_stmt_bind_param($stmt, "iiii", $userId, $receiver_id, $receiver_id, $userId);
    mysqli_stmt_execute($stmt);
    $latest_chat = mysqli_stmt_get_result($stmt);
    
// chỉ lấy danh sách những người đã nhắn tin

// $sql_users = "
//     SELECT DISTINCT u.user_id, u.fullname 
//     FROM users u
//     JOIN chit_chat c 
//     ON (u.user_id = c.sender_id OR u.user_id = c.receiver_id)
//     WHERE u.user_id != ? AND (c.sender_id = ? OR c.receiver_id = ?)
// ";
// $stmt = mysqli_prepare($conn, $sql_users);
// mysqli_stmt_bind_param($stmt, "iii", $userId, $userId, $userId);
// mysqli_stmt_execute($stmt);
// $users = mysqli_stmt_get_result($stmt);

?>