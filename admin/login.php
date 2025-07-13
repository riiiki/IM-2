<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Skyview Resort</title>
  <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST" action="admin_login.php">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
