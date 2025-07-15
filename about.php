<?php
include("user/auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/png" href="images/mountain.png">
  <title>About Us | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index2.php">SKYVIEW</a></h1>
        <nav>
          
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php" class="active">About</a>
          <a href="user/logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <main class="about-page">
      <section class="about-hero">
        <h2>About Skyview Resort</h2>
        <p>
          Perched in the heart of the mountains, Skyview Resort offers guests a
          peaceful escape from the bustle of city life. Whether you're chasing
          sunsets or savoring quiet mornings, our resort is designed to help
          you unwind, reflect, and reconnect.
        </p>
      </section>

      <section class="about-content">
        <div class="about-text">
          <h3>Our Story</h3>
          <p>
            Founded in 2010, Skyview began as a simple mountain hideaway for
            nature lovers. Over the years, we've grown into a full-service resort
            while keeping our commitment to natural beauty, sustainability, and
            warm Filipino hospitality.
          </p>

          <h3>What We Offer</h3>
          <ul>
            <li>Breathtaking views and sunsets</li>
            <li>Comfortable, locally inspired rooms</li>
            <li>Farm-to-table dining</li>
            <li>Fast and reliable WiFi</li>
            <li>Guided tours and activities</li>
          </ul>
        </div>

        <div class="about-image">
          
          <img src="images/about_view.jpg" alt="View from the resort" />
        </div>
      </section>
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
