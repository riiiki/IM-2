<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Skyview Resort</title>
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body class="wrapper-admin">
  <div class="login_container">
    <h2>Skyview Resort Login</h2>
    <form method="POST" action="unified_login.php">
      <select name="role" required>
        <option value="" disabled selected>Select Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <p>
        Don't have an account? <a href="register.php">Register Now</a><br>
        <a href="forgot_password.php">Forgot Password?</a>
      </p>
    </form>
  </div>
</body>
</html>
