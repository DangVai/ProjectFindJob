<?php
require_once("../config/db.php");

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $conn->real_escape_string($_POST["name"]); 
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO contact_messages (username, email, message, created_at) 
            VALUES ('$name', '$email', '$message', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../public/contact.php?message=success");
    } else {
        header("Location: ../public/contact.php?message=error");
    }

    $conn->close();
}
?>
