<?php
include '../user/config.php';

$email = $_POST['email'];
$role = $_POST['role'];
$token = bin2hex(random_bytes(16));

// Use default timezone if not already set
date_default_timezone_set('Asia/Manila');
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Prepare the right table
if ($role == 'user') {
    $stmt = $conn->prepare("UPDATE customer SET reset_token = ?, reset_expires = ? WHERE Email = ?");
} else {
    $stmt = $conn->prepare("UPDATE admins SET reset_token = ?, reset_expires = ? WHERE email = ?");
}

$stmt->bind_param("sss", $token, $expires, $email);
$stmt->execute();

// Debug and confirm
if ($stmt->affected_rows > 0) {
    // Optional: Verify the token really got updated (debugging)
    if ($role == 'user') {
        $verify = $conn->prepare("SELECT reset_token, reset_expires FROM customer WHERE Email = ?");
    } else {
        $verify = $conn->prepare("SELECT reset_token, reset_expires FROM admins WHERE email = ?");
    }
    $verify->bind_param("s", $email);
    $verify->execute();
    $result = $verify->get_result();
    $row = $result->fetch_assoc();

    echo "<p>Password reset link:</p>";
    echo "<a href='reset_password.php?token=" . urlencode($row['reset_token']) . "&role=$role'>Click here to reset</a>";
} else {
    echo "Email not found.";
}
?>
