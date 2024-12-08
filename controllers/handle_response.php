<?php
    session_start();
    require_once("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['notification_id'], $_POST['sender_id'], $_POST['id_post'])) {
        die("Thiếu dữ liệu cần thiết.");
    }
    $notificationId = intval($_POST['notification_id']);
    $senderId = intval($_POST['sender_id']);
    $postId = intval($_POST['id_post']);  // Lấy id_post từ POST
    $currentUserId = $_SESSION['user_id'];
    $isOwner = isset($_POST['is_owner']) ? filter_var($_POST['is_owner'], FILTER_VALIDATE_BOOLEAN) : false;

    if ($isOwner) {
        // Nếu là người đăng bài
        if (isset($_POST['accept'])) {
            // Thực hiện xử lý khi đồng ý
            $job_link = "../public/details_job.php?id=$postId"; // Tạo liên kết tới bài đăng

            // Gửi thông báo
            $message = "Bạn đã được chấp nhận làm công việc. <a href='$job_link' target='_blank'>Xem công việc tại đây</a>.";
        } elseif (isset($_POST['decline'])) {
            // Thực hiện xử lý khi từ chối
            $job_link = "../public/details_job.php?id=$postId"; // Tạo liên kết tới bài đăng

            // Gửi thông báo
            $message = "Yêu cầu ứng tuyển của bạn đã bị từ chối. Bạn có thể xem công việc tại <a href='$job_link' target='_blank'>xem tại đây</a>.";
        }

        // Gửi thông báo vào cơ sở dữ liệu
        $query = "INSERT INTO notifications (sender_id, receiver_id, id_post, message, created_at, is_read) 
                  VALUES (?, ?, ?, ?, NOW(), 0)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiis", $currentUserId, $senderId, $postId, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Thông báo đã được gửi đến người apply.'); window.location.href='../public/notification.php';</script>";
        } else {
            die("Lỗi khi gửi thông báo: " . $stmt->error);
        }
    }

 else {
            // Người apply gửi yêu cầu nhận công việc
            if ($currentUserId === $senderId) {
                echo "<script>alert('Bạn không thể gửi yêu cầu nhận công việc của chính mình.'); window.history.back();</script>";
                exit();
            }

            $jobTitle = isset($_POST['job_title']) ? $_POST['job_title'] : "Công việc chưa xác định";
            $message = " Tôi muốn nhận công việc: '$jobTitle'. Bạn có thể xem công việc tại <a href='../public/details_job.php?id=$postId' target='_blank'>xem tại đây</a>.";
            // $message = " Tôi muốn nhận công việc: '$jobTitle'. Bạn có thể xem công việc tại <a href='../public/details_job.php' target='_blank'>xem tại đây</a>.";

            // Gửi thông báo đến người đăng bài
            $query = "INSERT INTO notifications (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $currentUserId, $senderId, $message);
            
            if ($stmt->execute()) {
                echo "<script>alert('Yêu cầu nhận việc đã được gửi đến người đăng bài.'); window.location.href='../public/details_job.php?id=$user_id';</script>";
            } else {
                die("Lỗi khi gửi yêu cầu nhận việc: " . $stmt->error);
            }
        }
    }
    ?>
