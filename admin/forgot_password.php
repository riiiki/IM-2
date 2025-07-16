<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body>
  <div class="forgot-container">
    <h2>Forgot Password</h2>
    <form action="reset_link.php" method="POST">
      <select name="role" required>
        <option value="" disabled selected>Select Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="submit" value="Reset">
    </form>
    <p>Remembered your password? <a href="login.php">Back to Login</a></p>
  </div>
</body>
</html>
