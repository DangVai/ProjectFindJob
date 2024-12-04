<div class="header">
    <div class="box_logo">
        <img src="img/anh-weblogo.png" alt="">
    </div>
    <div class="nav">
        <p><b>Home</b></p>
        <p><b>About Us</b></p>
        <p><b>Contact</b></p>
    </div>
    <div class="chatbox">
        <a href="public/chat.php"><i class="fa-regular fa-comment-dots"></i></a>
    </div>
    <div class="inform">
        <i class="fa-regular fa-bell"></i>
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
                <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
            </div>
            <div>
                <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
            </div>
            <div>
                <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
            </div>
            <div>
                <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
            </div>
            <div>
                <a href="index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
            </div>
        </div>
    </div>
</div>