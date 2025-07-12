<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/jpg" href="images/skyview.jpg">
  <title>Skyview Resort</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <style>
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 450px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: slide-in 0.3s ease-out;
    }
  </style>
  <div class = "wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index.php"><span>SKYVIEW</span></a></h1>
        <nav>
          <!-- remove explore -->
          <!-- <a href="explore.html">Explore</a> -->
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="#" onclick="openModal('registerModal')">Register</a>
          <a href="#" onclick="openModal('loginModal')">Login</a>
        </nav>
      </div>

      <div id="registerModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal('registerModal')">&times;</span>
          <img src="images/logging.PNG" alt="">
          <h2>Register</h2>
          <form method="POST" action="admin/register.php">
            <label for="register-first-name">First Name:</label>
            <input type="text" id="register-first-name" name="first_name" required><br><br>

            <label for="register-last-name">Last Name:</label>
            <input type="text" id="register-last-name" name="last_name" required><br><br>

            <label for="register-email">Email:</label>
            <input type="email" id="register-email" name="email" required><br><br>

            <label for="register-phone">Phone Number:</label>
            <input type="tel" id="register-phone" name="phone_number" pattern="[0-9+ ]{7,}" required><br><br>

            <label for="register-password">Password:</label>
            <input type="password" id="register-password" name="password" required><br><br>

            <label for="register-date">Date Registered:</label>
            <input type="date" id="register-date" name="date_registered" required><br><br>

            <input type="submit" name="submit" value="Register">

            <div class="social-login">
              <button type="button" class="google-login">Sign up with Google</button>
              <button type="button" class="facebook-login">Sign up with Facebook</button>
            </div>
          </form>
        </div>
      </div>

      <div id="loginModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal('loginModal')">&times;</span>
          <img src="images/logging.PNG" alt="">
          <h2>Login</h2>
          <form method="POST" action="admin/login.php">
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="login_email" required><br><br>

            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="login_password" required><br><br>

            <input type="submit" name="login_submit" value="Login">
          </form>
        </div>
      </div>

      <div class="hero">
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

        <div class="booking">
          <h3>BOOK NOW</h3>
          <form id="booking-form" action="admin/booking.php" method="POST">
            <input type="date" name="checkin" placeholder="Check-in" required />
            <input type="date" name="checkout" placeholder="Check-out" required />
            <select name="room">
              <option>Standard Room</option>
              <option>Deluxe Rooms</option>
            </select>
            <button type="submit">Check availability</button>
          </form>
        </div>
        </section>
    </main>
    <script src="node.js"></script>
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
