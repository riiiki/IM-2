<?php
    session_start();
    session_destroy();
    header("Location: login.php");
    exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logged Out - Skyview</title>
  <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
  <div class="logout-message">
    <h2>You have been logged out.</h2>
    <a href="login.php">Login Again</a>
  </div>
</body>
</html>