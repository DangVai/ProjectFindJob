<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            position: relative;
            z-index: 1;
        }

        .sidebar {
            margin-top: 200px;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include_once "./header.php"; ?>
    </div>
    <div>
        <?php include_once "./sider.php"; ?>
    </div>
    <div id="main-content" class="p-4 p-md-5 pt-5">
        <table border="1">
            <thead>
                <tr>
                    <th>user_id</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>created_at</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
                    SELECT 
                        user_id,
                        fullname, 
                        username,
                        email,
                        phone,
                        created_at
                    FROM 
                        users
                    ORDER BY 
                        user_id ASC";

                // Thực hiện truy vấn và kiểm tra lỗi
                $result = $conn->query($sql);
                if (!$result) {
                    echo "<tr><td colspan='7'>Error executing query: " . $conn->error . "</td></tr>";
                } elseif ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr id="row-' . htmlspecialchars($row['user_id']) . '">
                            <td>' . htmlspecialchars($row['user_id']) . '</td>
                            <td>' . htmlspecialchars($row['fullname']) . '</td>
                            <td>' . htmlspecialchars($row['username']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['phone']) . '</td>
                            <td>' . htmlspecialchars($row['created_at']) . '</td>
                            <td>
                                <button onclick="viewUser(' . htmlspecialchars($row['user_id']) . ')" 
                                        style="background-color: #007bff; color: white;">
                                    View
                                </button>
                                <button onclick="deleteRow(' . htmlspecialchars($row['user_id']) . ')" 
                                        style="background-color: #dc3545; color: white; transition: background-color 0.3s ease;">
                                    Delete
                                </button>
                            </td>
                        </tr>';
                    }
                } else {
                    echo "<tr><td colspan='7'>No data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    function deleteRow(user_id) {
        if (!confirm("Are you sure you want to delete this user?")) {
            return;
        }
        fetch('delete/deleteusers.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${user_id}`
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                if (data.trim() === "success") {
                    const row = document.getElementById(`row-${user_id}`);
                    if (row) row.remove();
                    alert("User deleted successfully!");
                } else {
                    alert("Error deleting user: " + data);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to delete. Please try again later.");
            });
    }

    function viewUser(user_id) {
        window.location.href = `view.php?user_id=${user_id}`;
    }
</script>

</html>