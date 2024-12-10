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

//   Xác định số lượng thông báo mỗi trang 
$limit = 10; // Lấy 10 thông báo mỗi lần
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Lấy trang hiện tại từ URL
$offset = ($page - 1) * $limit;  // Tính toán offset để lấy đúng dữ liệu

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

//   Kiểm tra lỗi truy vấn
if ($notifications === false) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

//  Đếm tổng số thông báo để tính số trang 
$total_notifications = $conn->query("
    SELECT COUNT(*) AS total 
    FROM notifications 
    WHERE is_read = 0 AND user_id = $userId
")->fetch_assoc();
$total_pages = ceil($total_notifications['total'] / $limit);
////////////////////////////////////////////
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
    <link rel="stylesheet" href="cssfile/fix-header.css">
    <link rel="stylesheet" href="cssfile/Post.css">
</head>

<body>
    <div class="container-homePage">
        <div class="header">
            <div class="box_logo">
                <img src="img/anh-weblogo.png" alt="">
            </div>
            <div class="nav">
                <p><b>Home</b></p>
                <p><b><a href="./public/about.php" style="color:#fff">About Us</a></b></p>
                <p><b><a href="./public/contact.php">Contact</a></b></p>
            </div>
            <div class="chatbox">
                <a href="public/chat.php"><i class="fa-regular fa-comment-dots"></i></a>
            </div>
            <div class="inform">
                <a href="./public/notification.php"><i class="fa-regular fa-bell"></i></a>
            </div>
            <div class="account">
                <div class="box-account">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
            <div class="name-user">
                <p><?php echo ($userName) ?></p>
                <div class="dropdown-menu" id="account-menu">
                    <div>

                        <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile</a>
                    </div>
                    <div>
                        <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
                    </div>
                    <div>
                        <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
                    </div>
                    <div>
                        <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log
                            in</a>
                    </div>
                    <div>
                        <a href="controllers/logout.php"><i
                                class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_slider">
            <div class="box_img">
                <div class="title">
                    <h1>Reliable Hand and Foot Jobs - Flexible Hours</h1>
                </div>
                <div class="content">
                    <p>Discover thousands of exciting job opportunities with trustworthy and talented people, all with
                        just a click. Any job becomes easy and fast right now!</p>
                </div>
                <div class="change">
                    <div class="change1"></div>
                    <div class="change2"></div>
                    <div class="change3"></div>
                    <div class="change4"></div>
                </div>
                <img src="https://www.nlvgarden.org/wp-content/uploads/2020/08/meaning-01a.jpg" alt="">
                <img src="https://cdn-www.vinid.net/2020/03/D%E1%BB%8Bch-v%E1%BB%A5-d%E1%BB%8Dn-d%E1%BA%B9p-nh%C3%A0-c%E1%BB%ADa-l%C3%A0-l%C3%A0m-g%C3%AC.jpg"
                    alt="">
                <img src="https://ktmt.vnmediacdn.com/stores/news_dataimages/nguyenthiluan/052019/27/14/in_article/2300_71546H-2.jpg"
                    alt="">
                <img src="https://png.pngtree.com/thumb_back/fh260/background/20210910/pngtree-gardener-pruning-greenery-in-spring-image_839423.jpg"
                    alt="">
            </div>
        </div>
        <div class="body-top">
            <div class="add">
                <button><a href="./public/create_post.php" style="color:#fff">ADD POST</a></button>
            </div>

            <div class="searchBox">
                <form class="search-bar" method="POST" acction="index.php">
                    <input name="search-title" type="text" class="search-job" placeholder="Tìm kiếm việc làm">
                    <input name="search-address" type="text" class="search-address" placeholder="Địa chỉ">
                    <button type="POST" name="search-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="body-content">
            <div class="fifter">
                <div class="fifter-job">
                    <h1>Field</h1>
                    <h2>Gardener</h2>
                    <h2>Cleaner</h2>
                    <h2>Driver</h2>
                    <h2>Others</h2>>
                </div>
                <div class="fifter-address">
                    <h1>Address</h1>
                    <h2>Son Tra</h2>
                    <h2>Cam Le</h2>
                    <h2>Lien Chieu</h2>
                    <h2>Others</h2>
                </div>
            </div>
            <div class="box-post">

                <?php
                require_once './controllers/display_post.php';

                ?>

                <div class="posts">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="post" data-address="<?php echo htmlspecialchars($post['dia_chi']); ?>"
                                data-field="<?php echo htmlspecialchars($post['linh_vuc']); ?>">
                                <div class="card-profile">
                                    <a
                                        href="./public/viewProfile.php?user_id=<?php echo htmlspecialchars($post['user_id']); ?>">
                                        <div class="avatar">
                                            <img src="<?php echo htmlspecialchars(!empty($post['link_anh']) ? $post['link_anh'] : './uploads/default_avatar.png'); ?>"
                                                alt="Avatar" class="rounded-circle" width="80" height="80">
                                        </div>
                                    </a>
                                    <div class="name">
                                        <a
                                            href="./public/viewProfile.php?user_id=<?php echo htmlspecialchars($post['user_id']); ?>">
                                            <p style="color: #000">
                                                <?php echo htmlspecialchars(!empty($post['fullname']) ? $post['fullname'] : "Unknown User"); ?>
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="title-content">
                                        <h3><?php echo htmlspecialchars($post['linh_vuc']); ?></h3>
                                        <div class="package"><?php echo htmlspecialchars($post['goi_dang_ky']); ?></div>
                                        <p class="time-post"><?php echo htmlspecialchars($post['thoi_gian']); ?></p>
                                    </div>
                                    <div class="main-content">
                                        <p><b>Price:</b> <?php echo htmlspecialchars($post['price']); ?></p>
                                        <p><b>Address:</b> <?php echo htmlspecialchars($post['dia_chi']); ?></p>
                                        <p class="content-post"><b>Content:</b>
                                            <?php echo htmlspecialchars($post['noi_dung']); ?></p>
                                    </div>
                                </div>
                                <button class="btn-link show-more-btn">
                                    <a href="./public/details_job.php?id=<?php echo htmlspecialchars($post['id_post']); ?>">View
                                        details</a>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No posts available.</p>
                    <?php endif; ?>
                </div>



            </div>


        </div>
    </div>
    <div class="promote">
        <h1 style="margin-bottom: 40px; ">JOB ADVERTISEMENT</h1>
    </div>
    <div class="body-foot">
        <div class="advert">
            <div class="card-advert">
                <div class="advert-img">
                    <img src="https://kinhtenongthon.vn/data/data/baoinktnt/2023/05/05/8b.jpg" alt="">
                </div>
                <div class="advert-content">
                    <p class="text-content">Gardeners typically work outdoors, using tools such as shovels, hoes, and
                        grass cutters to keep plants and landscapes healthy. This job requires patience, attention to
                        detail, and a love for nature, providing a healthy living space that is close to the
                        environment.</p>

                </div>
            </div>
            <div class="card-advert">
                <div class="advert-img">
                    <img src="https://afamilycdn.com/150157425591193600/2023/9/20/vc3ac-sao-be1baa1n-ce1baa7n-thuc3aa-ngc6b0e1bb9di-trc3b4ng-tre1babb-te1baa1i-nhc3a03f-16951990556701460520031.jpg"
                        alt="">
                </div>
                <div class="advert-content">
                    <p class="text-content">Professional and dedicated childcare, where children are loved, learn, and
                        grow in a safe and warm environment. With a fun, colorful space and engaging educational
                        activities, we are committed to bringing joy to the children every day, giving parents peace of
                        mind when entrusting their little ones to us.</p>
                </div>
            </div>
            <div class="card-advert">
                <div class="advert-img">
                    <img src="https://vesinhnhatoancau.com/wp-content/uploads/2022/01/don-nha-theo-gio-dan-phuong-1.jpg"
                        alt="">
                </div>
                <div class="advert-content">
                    <p class="text-content">We guarantee to provide a clean, tidy, and fresh living and working space.
                        Whether it's cleaning homes, offices, or large construction sites, we are always committed to
                        delivering quality that exceeds expectations, helping you save time and enjoy a more comfortable
                        life. Let us clean, so you can live healthier!</p>

                </div>
            </div>
        </div>
    </div>
    <div class="top-footer"></div>
    <div class="footer">
        <div class="left-footer">
            <h1>FindJob</h1>
            <p>FindJob offers unparalleled efficiency in addressing the urgent needs of individuals, connecting them
                with trusted and professional experts who are dedicated to delivering exceptional service in every
                field.</p>
        </div>
        <div class="right-footer">
            <div class="components">
                <h3>Components</h3>
                <h5>Home</h5>
                <h5>About Us</h5>
                <h5>Contact</h5>
            </div>
            <div class="feature">
                <h3>Feature</h3>
                <h5>Post a job search</h5>
                <h5>Apply Jobs</h5>
                <h5>Job and address filters</h5>
                <h5>Post a job looking for a job</h5>
            </div>
            <div class="contact">
                <h3>Contact</h3>
                <div class="logo">
                    <div><i class="fa-brands fa-facebook"></i></div>
                    <div><i class="fa-brands fa-square-instagram"></i></div>
                    <div><i class="fa-solid fa-envelope"></i></div>
                    <div><i class="fa-brands fa-linkedin"></i></div>
                </div>
            </div>
        </div>
    </div>

    <script src="jsfile/slideHomePage.js"></script>
    <script src="jsfile/account.js"></script>
    <script src="jsfile/filter_addressORfield.js"></script>
</body>

</html>