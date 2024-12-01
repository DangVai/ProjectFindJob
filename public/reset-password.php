<?php
// Kiểm tra nếu có email được gửi qua liên kết
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    die("Invalid reset link.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="../bootstrap/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg mt-5">
                    <div class="card-body">
                        <h3 class="text-center">Reset Password</h3>
                        <form action="../controllers/process-reset-password.php" method="POST">
                            <!-- Email hidden để nhận dạng -->
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control"
                                    id="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>