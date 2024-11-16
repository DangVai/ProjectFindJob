<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Thêm Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/register.css">
</head>

<body>
    <form action="../controllers/AuthController.php" method="POST">
        <div class="container">
            <h2 class="text-center">Register</h2>

            <label for="fullname">Full name:</label>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="fullname" placeholder="Nhập họ tên đầy đủ của bạn"
                        required />
                </div>
            </div>

            <label for="username">Username:</label>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user-tag"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng ký" required />
                </div>
            </div>

            <label for="email">Email:</label>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Nhập email đăng ký" required />
                </div>
            </div>

            <label for="phone">Phone number:</label>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                    <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại đăng ký"
                        required />
                </div>
            </div>

            <label for="password">Password:</label>
            <div class="form-group_password">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required />
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu"
                        required />
                </div>
            </div>

            <!-- Hiển thị thông báo lỗi nếu có -->
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'password_mismatch') {
                echo "<p style='color: red;'>Mật khẩu và xác nhận mật khẩu không khớp. Vui lòng thử lại.</p>";
            } 
            ?>
            <button type="submit" name="register" class="btn-primary">Register</button>

            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </form>
</body>

</html>