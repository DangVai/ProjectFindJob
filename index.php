<?php
session_start();

if (isset($_SESSION['username'])) {
    $userName = $_SESSION['username'];
} else {
    $userName = "Guest"; // Giá trị mặc định nếu không có session
}
?>


<?php

require 'config/db.php';

// Lấy thông tin user_id từ session
$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

// Xác định số lượng thông báo mỗi trang
$limit = 10; // Lấy 10 thông báo mỗi lần
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Lấy trang hiện tại từ URL
$offset = ($page - 1) * $limit; // Tính toán offset để lấy đúng dữ liệu

// Truy vấn để lấy thông báo
$notifications = $conn->query("
    SELECT notifications.id, post.noi_dung AS title, users.fullname AS name, notifications.created_at 
    FROM notifications
    JOIN post ON notifications.id_post = post.id_post
    JOIN users ON notifications.user_id = users.user_id
    WHERE notifications.is_read = 0 AND notifications.user_id = $userId
    ORDER BY notifications.created_at DESC
    LIMIT $limit OFFSET $offset
");

// Kiểm tra lỗi truy vấn
if ($notifications === false) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Đếm tổng số thông báo để tính số trang
$total_notifications = $conn->query("
    SELECT COUNT(*) AS total 
    FROM notifications 
    WHERE is_read = 0 AND user_id = $userId
")->fetch_assoc();
$total_pages = ceil($total_notifications['total'] / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cssfile/home.css">
    <link rel="stylesheet" href="cssfile/account.css">
    <link rel="stylesheet" href="cssfile/footer.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="box_logo">
                <img src="https://files.oaiusercontent.com/file-JnPcSl24aD1n46Abo1tsEsvk?se=2024-11-19T08%3A21%3A19Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D604800%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Df06b750f-85fe-44ca-b237-45a456ef83c5.webp&sig=Bae6Pyxch/izjVZ08WlUzzcXN8BAhQOd3moTg19ydtY%3D" alt="">
            </div>
            <div class="nav">
                <p><b>Home</b></p>
                <p><b>About Us</b></p>
                <p><b>Planters</b></p>
            </div>
            <div class="chatbox">
                <a href="public/chat.php"><i class="fa-regular fa-comment-dots"></i></a>
            </div>
            <div class="inform">
                <i class="fa-regular fa-bell"></i>
            </div>
            <div class="account">
                <i class="fa-regular fa-user"></i>
                <div class="dropdown-menu" id="account-menu">
                    <ul>
                        <li><a href="public/register.php">Đăng ký</a></li>
                        <li><a href="public/login.php">Đăng nhập</a></li>
                        <li><a href="public/logout.php">Đăng xuất</a></li>
                        <li><a href="#">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="box_slider">
            <div class="box_img">
                <div class="title">
                    <h2>Việc làm Hand and Foot uy tin - Thời gian linh hoạt</h2>
                </div>
                <div class="content">
                    <p>Khám phá hàng ngàn việc làm hấp dẫn và những con người uy tín, tài năng chỉ với một cái nhấp chuột. Hành trình thành công của bạn bắt đầu ngay tại bây giờ!</p>
                </div>
                <div class="chosse">
                    <button class="chosse1">Muốn tìm việc</button>
                    <button class="chosse1">Muốn tuyển việc</button>
                </div>
                <div class="change">
                    <div class="change1"></div>
                    <div class="change2"></div>
                    <div class="change3"></div>
                    <div class="change4"></div>
                </div>
                <img src="https://www.nlvgarden.org/wp-content/uploads/2020/08/meaning-01a.jpg" alt="">
                <img src="https://cdn.tgdd.vn/Files/2023/01/08/1501445/y-nghia-phong-tuc-don-dep-nha-cua-don-tet-hang-nam-la-gi-202301090813155617.jpg" alt="">
                <img src="https://cuuhonhanh24h.com/wp-content/uploads/2023/04/cuu-ho-xe-may-4.jpg" alt="">
                <img src="https://png.pngtree.com/thumb_back/fh260/background/20210910/pngtree-gardener-pruning-greenery-in-spring-image_839423.jpg" alt="">
            </div>    
        </div>
        <div class="body-top">
            <div class="add">
                <button>Thêm Bài +</button>
            </div>
            <div class="searchBox">
                <div class="search-bar">
                    <input type="text" class="search-job" placeholder="Tìm kiếm việc làm">
                    <input type="text" class="search-address" placeholder="Địa chỉ">
                    <button>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="body-content">
            <div class="fifter">
                <div class="fifter-job">
                    <h1>Lĩnh Vực</h1>
                    <h2>Làm Vườn</h2>
                    <h2>Dọn Dẹp</h2>
                    <h2>Bóc Vác</h2>
                    <h2>Khác</h2>
                </div>
                <div class="fifter-address">
                    <h1>Địa Chỉ</h1>
                    <h2>Sơn Trà</h2>
                    <h2>Cẩm Lệ</h2>
                    <h2>Liên Chiểu</h2>
                    <h2>Khác</h2>
                </div>
            </div>
            <div class="box-post">
                <div class="post">
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post1">
                        <div class="left">
                            <div class="card-profile">
                                <div class="avatar">
                                    <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                </div>
                                <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                    <p><b>Price:</b> 150.000đ</p>
                                    <p><b>Address:</b> Sơn Trà</p>
                                    <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="card-profile">
                                    <div class="avatar">
                                        <img src="https://media.istockphoto.com/id/1142192548/vi/vec-to/h%E1%BB%93-s%C6%A1-avatar-ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-h%C3%ACnh-b%C3%B3ng-khu%C3%B4n-m%E1%BA%B7t-nam-ho%E1%BA%B7c-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-b%E1%BB%8B-c%C3%B4-l%E1%BA%ADp-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.jpg?s=170667a&w=0&k=20&c=BJHP79YRvSNDATYVu-SDYae8UWCzGaave5JhBYxsjro=" alt="">
                                    </div>
                                    <div class="name">hồ viết tiến</div>
                            </div>
                            <div class="card-content">
                                <h3>Title of job</h3>
                                <div class="main-content">
                                        <p><b>Price:</b> 150.000đ</p>
                                        <p><b>Address:</b> Sơn Trà</p>
                                        <p><b>Content:</b> Lorem ipsum dolor sit amet consectetur adipisic...</p>
                                </div>
                            </div>
                        </div>
                    </div>  

                </div>
            </div>
        </div>
        <div class="body-foot">
            <div class="advert">
                <div class="box1">
                    <div class="box1-1">
                        <div></div>
                    </div>
                    <div class="box1-2">
                        <div class="box1-2-top"></div>
                        <div class="box1-2-bottom"></div>
                    </div>
                    <div class="box1-3">
                        <div></div>
                    </div>
                </div>
                <div class="box2">
                    <div></div>
                </div>
                <div class="box3">
                    <div></div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Về Chúng Tôi</h3>
                    <p>Chúng tôi cung cấp việc làm và làm việc uy tín, chất lượng với thời gian linh hoạt, đáp ứng nhu cầu của người tìm việc và nhà tuyển dụng.</p>
                </div>
                <div class="footer-section">
                    <h3>Liên Hệ</h3>
                    <p><i class="fa-solid fa-envelope"></i> support@example.com</p>
                    <p><i class="fa-solid fa-phone"></i> +84 123 456 789</p>
                </div>
                <div class="footer-section">
                    <h3>Kết Nối Với Chúng Tôi</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="jsfile/slideHomePage.js"></script>
    <script src="jsfile/account.js"></script>

</body>
</html>