<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/login.css">
    <!-- Custom fonts for this template-->
    <link href="../bootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../bootstrap/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<style>
    a {
        color: #060606;
        text-decoration: none;
        background-color: transparent;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 500px;
        padding: 40px;
        transform: translate(-50%, -50%);
        box-sizing: border-box;
        background-color: rgb(183 224 191 / 70%);
        box-shadow: 2px 19px 25px 3px rgba(0, 0, 0, .6);
        border-radius: 10px;
        color: #000000;
    }

    body {
        background-image: url("https://hoanghamobile.com/tin-tuc/wp-content/uploads/2023/07/hinh-dep-5.jpg");
        /* Light gray background */
    }
</style>

<body>
    <form action="../controllers/handlelogin.php" method="POST">
        <div class="container">
            <h2 class="text-center">Login</h2>

            <label for="email">Email:</label>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Nhập email" required />
            </div>

            <label for="password">Password:</label>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required />
            </div>
            <?php
            $error = $_GET['error'] ?? '';
            switch ($error) {
                case 'missing_fields':
                    $errorMessage = 'Vui lòng điền đầy đủ email và mật khẩu.';
                    break;
                case 'email_not_found':
                    $errorMessage = 'Email không tồn tại.';
                    break;
                case 'wrong_password':
                    $errorMessage = 'Mật khẩu không chính xác.';
                    break;
                case 'invalid_credentials':
                    $errorMessage = 'Thông tin đăng nhập không hợp lệ.';
                    break;
                default:
                    $errorMessage = '';
                    break;
            }

            if (!empty($errorMessage)) {
                echo "<p style='color: red;'>$errorMessage</p>";
            }
            ?>
            <button type="submit" name="login" class="btn-primary">Login</button>
            <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="customCheck">
                    <label class="custom-control-label" for="customCheck">RememberMe</label>
                </div>
            </div>

            <div class="text-center">
                <a class="small" href="forgot-password.php">
                    <p>Forgot Password?</p>
                </a>
            </div>
            <a href="index.html" class="btn btn-google btn-user btn-block">
                <i class="fab fa-google fa-fw"></i> Login with Google</a>
            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
            </a>
            <p>Bạn muốn đăng ký tài khoản không <a href="register.php">register</a></p>
        </div>
    </form>
</body>
<!-- Bootstrap core JavaScript-->
<script src="../bootstrap/vendor/jquery/jquery.min.js"></script>
<script src="../bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../bootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../bootstrap/js/sb-admin-2.min.js"></script>

</html>