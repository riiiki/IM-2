<?php
include '../user/config.php';

$token = $_POST['token'];
$role = $_POST['role'];
$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

if ($role == 'user') {
    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE reset_token=? AND reset_expires > NOW()");
} else {
    $stmt = $conn->prepare("SELECT id FROM admins WHERE reset_token=? AND reset_expires > NOW()");
}
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $id = ($role == 'user') ? $row['CustomerID'] : $row['id'];

    if ($role == 'user') {
        $update = $conn->prepare("UPDATE customer SET PasswordHash=?, reset_token=NULL, reset_expires=NULL WHERE CustomerID=?");
    } else {
        $update = $conn->prepare("UPDATE admins SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?");
    }
    $update->bind_param("si", $new_password, $id);
    $update->execute();

    echo "Password has been reset. <a href='login.php'>Login now</a>";
} else {
    echo "Invalid or expired token.";
}
?>
