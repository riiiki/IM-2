<?php
session_start();
include('../user/config.php');

$role = $_POST['role'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($role === 'admin') {
    $query = "SELECT id, email, password FROM admins WHERE email = ?";
} elseif ($role === 'user') {
    $query = "SELECT CustomerID, Email, PasswordHash FROM customer WHERE Email = ?";
} else {
    echo "<script>alert('Invalid role selected'); window.location.href='login.php';</script>";
    exit();
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $hashed_password = ($role === 'admin') ? $row['password'] : $row['PasswordHash'];

    if (password_verify($password, $hashed_password)) {
        // Set session
        $_SESSION['id'] = ($role === 'admin') ? $row['id'] : $row['CustomerID'];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: dash_admin.php");
        } else {
            header("Location: ../index2.php");
        }
        exit();
    }
}

echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
exit();
