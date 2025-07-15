<?php
session_start();
require '../user/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_logged_in'] = true;
        header("Location: dash_admin.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
?>
