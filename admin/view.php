<?php include 'controll/view.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cssheader/profiles.css">
</head>

<body>
    <div class="container">
        <?php include_once "./header.php"; ?>
    </div>
    <div>
        <?php include_once "./sider.php"; ?>
    </div>
    <div id="main-content" class="p-4 p-md-5 pt-5">
            <div class="profile-container">
        <h1 class="profile-title">Profile Details</h1>
        <table class="profile-table">
            <tr>
                <th>User ID</th>
                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                    <tr>
                        <th>Profile Image</th>
                        <td><img src="<?php echo htmlspecialchars($row['link_anh']); ?>" alt="Profile Image" class="profile-image">
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td class="profile-address"><?php echo htmlspecialchars($row['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    </tr>
                    <tr>
                        <th>Birthday</th>
                        <td><?php echo htmlspecialchars($row['birthday']); ?></td>
                    </tr>
                    <tr>
                        <th>Rating</th>
                        <td><?php echo htmlspecialchars($row['danh_gia']); ?></td>
                    </tr>
                </table>
            </div>
    </div>
</body>
