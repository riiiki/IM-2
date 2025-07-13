<?php
include("user/auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/jpg" href="images/skyview.jpg">
  <title>Rooms | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index2.php">SKYVIEW</a></h1>
        <nav>
          <!-- remove explore -->
          <!-- <a href="explore.html">Explore</a> -->
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="user/logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <main class="main-container">
      <section class="welcome">
        <h2>Our <span>Rooms</span></h2>
        <p>
          From cozy nooks to luxurious suites, Skyview offers a variety of rooms to suit every guest. Experience comfort with a view.
        </p>
        <!-- fix table/border here -->
      </section>

      <section class="middle-section">
        <div class="middle-image">
          <!-- side by side -->
          <!-- try to show how many rooms are available -->
          <p>Standard Rooms</p>
          <img src="images/double.jpeg">
          <!-- <button> </button> -->
          <p>Deluxe Rooms</p>
          <img src="images/family.jpeg">
          <!-- <button> </button> -->

          <!-- description of rooms -->
          <!-- <p>Private Balconies</p>
          <p>Daily Housekeeping</p> -->
        </div>
        <div class="booking">
          <h3>CHECK AVAILABILITY</h3>
          <form action="user/booking.php" method="POST">
            <input type="date" name="checkin" required/>
            <input type="date" name="checkout required"/>
            <select name="room" required>
              <option>Standard Room</option>
              <option>Deluxe Rooms</option>
            </select>
            <button type="submit">Book Now</button>
          </form>
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


      
