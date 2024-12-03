<?php
require_once '../config/db.php';

// Fetch the user_id from the query string
$user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;

// Check if user_id is valid
if ($user_id <= 0) {
    echo "Invalid user ID.";
    exit;
}

// SQL query to get the user profile details
$sql = "
    SELECT 
        u.user_id, 
        u.fullname, 
        u.username, 
        u.email, 
        u.phone, 
        u.created_at, 
        p.link_anh, 
        p.address, 
        p.gender, 
        p.birthday, 
        p.danh_gia
    FROM 
        users u
    LEFT JOIN 
        profile p ON u.user_id = p.user_id
    WHERE 
        u.user_id = $user_id
";

// Execute the query
$result = $conn->query($sql);

// Check if data exists
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No profile data found for this user.";
    exit;
}

$conn->close();
?>