<?php
    session_start();
    include "config.php";

    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    echo "<script>alert('You must be logged in as a user to access this page.'); window.location.href='admin/login.php';</script>";
    exit();
    }

    $loggedInUserId = $_SESSION['id'];

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