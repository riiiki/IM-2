<?php
$token = $_GET['token'];
$role = $_GET['role'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body>
  <h2>Reset Password</h2>
  <form method="POST" action="reset_process.php">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br><br>
    <input type="submit" value="Reset Password">
  </form>
</body>
</html>
