<?php
include("user/auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="#">SKYVIEW</a></h1>
        <nav>
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <span>Welcome, <?php echo htmlspecialchars($loginUsername); ?>!</span>
          <a href="user/logout.php">Logout</a>
        </nav>
      </div>
      <div class="hero">
        <img src="../../images/beach.jpeg" alt="Sunset Cottages" />
        <h2 class="hero-text">CHASE<br>THE<br>SUNSETS</h2>
      </div>
    </header>

    <main class="main-container">
      <section class="welcome">
        <h2>Welcome to <span>Skyview</span></h2>
        <p>
          Nestled in the heart of the mountains, where every evening ends in golden
          light and every morning begins with peace. Discover sunsets that stay
          with you long after the day ends.
        </p>
        <div class="features">
          <p>High Speed WIFI</p>
          <p>Complimentary Breakfast</p>
          <p>Premier Sunsets</p>
        </div>
      </section>

      <section class="middle-section">
        <div class="booking">
          <h3>BOOK NOW</h3>
          <form id="booking-form" action="user/booking.php" method="POST">
            <input type="date" name="checkin" required />
            <input type="date" name="checkout" required />
            <select name="room">
                <option>Standard Room</option>
                <option>Deluxe Rooms</option>
            </select>
            <button type="submit">Check availability</button>
          </form>
        </div>
      </section>
    </main>

    <footer>
      <p>© 2025 Skyview Resort. All rights reserved.</p>
      <p>📞 +63 960 863 2989</p>
    </footer>
  </div>
  <script src="../../node.js"></script>
</body>
</html>