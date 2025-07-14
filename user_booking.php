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
  <title>Your Bookings | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" type="image/png" href="images/mountain.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index.php"><span>SKYVIEW</span></a></h1>
        <nav>
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php" class="active">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <section class="hero">
      <img src="images/sort.jpg" alt="Bookings Banner">
      <div class="hero-text">My Bookings</div>
    </section>

    <main class="main-container">
      <div class="booking" style="width:100%; max-width:900px;">
        <h3 style="text-align:center;">My Bookings</h3>
        <?php if ($result->num_rows > 0): ?>
          <div class="booking-table-container">
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Check-in</th>
                  <th>Check-out</th>
                  <th>Room</th>
                  <th>Booked On</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['checkin']); ?></td>
                    <td><?= htmlspecialchars($row['checkout']); ?></td>
                    <td><?= htmlspecialchars($row['room_details']); ?></td>
                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
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
