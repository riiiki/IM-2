<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "IAMTWO";

$conn = new mysqli($servername, $username, $password, $database, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remove this:
// session_start();
?>
