<?php
session_start();
include "config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
     echo "<script>
        alert('You must be logged in to access this page.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

$loggedInUserId = $_SESSION['user_id'];

// Get full name
$stmt = $conn->prepare("SELECT FullName FROM Customer WHERE CustomerID = ?");
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $loginUsername = $row['FullName'];
} else {
    $loginUsername = "Guest";
}

$stmt->close();
?>