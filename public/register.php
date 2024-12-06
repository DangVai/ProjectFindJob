<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Thêm Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/dangky.css">
    <!-- Custom fonts for this template-->
    <link href="../bootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../bootstrap/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<style>
        /* Modal background */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    /* Modal content */
    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 300px;
        text-align: center;
    }

    /* Close button */
    .close-modal {
        display: block;
        margin-left: auto;
        margin-right: 0;
        font-size: 18px;
        background: none;
        border: none;
        color: red;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 15px;
    }

    .modal-content h2 {
        margin-top: 0;
    }

    .modal-content button {
        margin-top: 10px;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .modal-content button:hover {
        background-color: #0056b3;
    }
    .input-group-addon i {
        font-size: 16px;
        width: 33px;
        height: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 4px;
        background-color: #ffffff;
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
        .input-group-addon i {
        font-size: 16px;
        width: 33px;
        height: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 4px;
        background-color: #ffffff;
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
</style>
<body>
    <form action="../controllers/AuthController.php" method="POST">
        <div class="container">
            <h2 class="text-center">Register</h2>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="fullname" placeholder="Nhập họ tên đầy đủ của bạn"
                        required />
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user-tag"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng ký" required />
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Nhập email đăng ký" required />
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                    <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại đăng ký"
                        required />
                </div>
            </div>
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
            if (isset($_GET['error'])) {
                echo "<p style='color: red;'>";
                switch ($_GET['error']) {
                    case 'password_mismatch':
                        echo "Mật khẩu và xác nhận mật khẩu không khớp. Vui lòng thử lại.";
                        break;
                    case 'password_too_short':
                        echo "Mật khẩu phải có ít nhất 6 ký tự.";
                        break;
                    case 'phone_too_short':
                        echo "Số điện thoại phải có ít nhất 10 số.";
                        break;
                    case 'username_exists':
                        echo "username đã tồn tại. Vui lòng thử lại.";
                        break;
                    case 'email_exists':
                        echo "emailđã tồn tại. Vui lòng thử lại.";
                        break;
                    case 'phone_exists':
                        echo "số điện thoại đã tồn tại. Vui lòng thử lại.";
                        break;
                    case 'fail':
                        echo "Lỗi đăng ký. Vui lòng thử lại.";
                        break;
                    default:
                        echo "Đã xảy ra lỗi không xác định. Vui lòng thử lại.";
                        break;
                }
                echo "</p>";
            }
            ?>   
            <button type="submit" name="register" class="btn-primary">Register</button>

            <hr>
            <a href="#" class="btn btn-google btn-user btn-block">
                <i class="fab fa-google fa-fw"></i> Register with Google
            </a>
            <a href="#" class="btn btn-facebook btn-user btn-block">
                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
            </a>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </form>
<!-- Modal OTP -->
<div id="otpModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <form method="POST" action="../controllers/verify.php">
            <label for="otp">Enter the OTP sent to your email:</label>
            <input type="text" name="otp" required>
            <input type="submit" name="verify_otp" value="Verify OTP">
          </form>
    </div>
</div>

</body>
<script src="../jsfile/dangky.js"></script>

</html>