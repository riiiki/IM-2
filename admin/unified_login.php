<?php
session_start();
include('../user/config.php');

$role = $_POST['role'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($role === 'admin') {
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
} elseif ($role === 'user') {
    $stmt = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
} else {
    echo "<script>alert('Invalid role'); window.location.href='login.php';</script>";
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $hashed_password = ($role === 'admin') ? $row['password'] : $row['PasswordHash'];

    if (password_verify($password, $hashed_password)) {
        $_SESSION['id'] = ($role === 'admin') ? $row['id'] : $row['CustomerID'];
        $_SESSION['email'] = $row['email'] ?? $row['Email'];
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: dash_admin.php");
        } else {
            header("Location: ../index2.php");
        }
        exit();
    }
}

echo "<script>alert('Invalid login credentials'); window.location.href='login.php';</script>";
exit();
?>
