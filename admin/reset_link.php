<?php
include '../user/config.php';

$email = $_POST['email'];
$role = $_POST['role'];
$token = bin2hex(random_bytes(16));
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

if ($role == 'user') {
    $stmt = $conn->prepare("UPDATE customer SET reset_token=?, reset_expires=? WHERE Email=?");
} else {
    $stmt = $conn->prepare("UPDATE admins SET reset_token=?, reset_expires=? WHERE email=?");
}

$stmt->bind_param("sss", $token, $expires, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Password reset link: <a href='reset_password.php?token=$token&role=$role'>Click here to reset</a>";
} else {
    echo "Email not found.";
}
?>
