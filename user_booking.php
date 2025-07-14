<?php
session_start();
require 'user/config.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('You must be logged in to view your bookings.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT checkin, checkout, room_details, created_at FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Your Bookings | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
  .booking-container {
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
  }

  .booking-table {
    width: 100%;
    border-collapse: collapse;
  }

  .booking-table th, .booking-table td {
    padding: 14px;
    border: 1px solid #ccc;
    text-align: center;
  }

  .booking-table th {
    background-color: #f5f5f5;
    color: #333;
    font-weight: bold;
  }

  .booking-title {
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
  }

  body {
    background-image: url('images/your-background.jpg'); /* change ni */
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    font-family: Arial, sans-serif;
  }
  
</style>
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index.php"><span>SKYVIEW</span></a></h1>
        <nav>
          <a href="rooms.php">Rooms</a>
          <a href="user_bookings.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <main>
        <div class="booking-container">
            <h2 class="booking-title">My Bookings</h2>
            <?php if ($result->num_rows > 0): ?>
            <table class="booking-table">
                <tr>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Room</th>
                <th>Booked On</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['checkin']); ?></td>
                    <td><?= htmlspecialchars($row['checkout']); ?></td>
                    <td><?= htmlspecialchars($row['room_details']); ?></td>
                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
            <?php else: ?>
            <p style="text-align:center;">You have no bookings yet.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
      <p>© 2025 Skyview Resort. All rights reserved.</p>
      <p>📞 +63 960 863 2989</p>
      <div class="social-links">
        <h4>Stay Connected</h4>
        <div class="icon-buttons">
          <a href="https://www.facebook.com/profile.php?id=100063647214137" target="_blank" class="icon facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com" target="_blank" class="icon twitter"><i class="fab fa-twitter"></i></a>
          <a href="https://ph.pinterest.com/pin/30328997485654246/" target="_blank" class="icon pinterest"><i class="fab fa-pinterest-p"></i></a>
          <a href="https://www.instagram.com/islandskyview.resort/?hl=en" target="_blank" class="icon instagram"><i class="fab fa-instagram"></i></a>
          <a href="http://youtube.com/@MrBeast" target="_blank" class="icon youtube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </footer>
  </div>
</body>
</html>
