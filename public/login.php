<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../cssfile/register.css">
</head>

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
            <button type="submit" name="login" class="btn-primary">Login</button>

            <p>Bạn muốn đăng ký tài khoản không <a href="register.php">register</a></p>
        </div>
    </form>
</body>

</html>