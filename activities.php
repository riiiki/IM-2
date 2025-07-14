<?php
include("user/auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/png" href="images/mountain.png">
  <title>Activities</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/activities.css" />
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
          <a href="activities.php" class="active">Activities</a>
          <a href="about.php">About</a>
          <a href="user/logout.php">Logout</a>
        </nav>
      </div>
    </header>
<section class="activities-page">
  <div class="activities-header">
    <h2>Our Activities</h2>
    <p>Fun, relaxing, and exciting options for all ages.</p>
  </div>

  <div class="slider">
    <input type="radio" name="slider" id="slide1" checked>
    <input type="radio" name="slider" id="slide2">
    <input type="radio" name="slider" id="slide3">
    <input type="radio" name="slider" id="slide4">

    <div class="slides">
  
      <div class="slide s1">
        <img src="https://images.pexels.com/photos/10343118/pexels-photo-10343118.jpeg" alt="Sunset Watching">
        <div class="caption">
          <h3>Sunset Watching</h3>
          <p>As the day comes to an end, you are welcomed by the breathtaking view of the sunset.</p>
        </div>
        <label for="slide4" class="nav-btn back-btn">← Back</label>
        <label for="slide2" class="nav-btn next-btn">Next →</label>
      </div>

      <div class="slide s2">
        <img src="https://img.freepik.com/premium-photo/group-friends-gathered-around-fire-night_713163-3749.jpg" alt="Bonfire Night">
        <div class="caption">
          <h3>Bonfire Night</h3>
          <p>Gather around the fire, share stories, and roast marshmallows.</p>
        </div>
        <label for="slide1" class="nav-btn back-btn">← Back</label>
        <label for="slide3" class="nav-btn next-btn">Next →</label>
      </div>

      <div class="slide s3">
        <img src="https://media-cdn.tripadvisor.com/media/attractions-splice-spp-674x446/13/47/a1/46.jpg" alt="Sunrise Yoga">
        <div class="caption">
          <h3>Sunrise Yoga</h3>
          <p>Begin your morning with gentle movements and peaceful stretches.</p>
        </div>
        <label for="slide2" class="nav-btn back-btn">← Back</label>
        <label for="slide4" class="nav-btn next-btn">Next →</label>
      </div>

      <div class="slide s4">
        <img src="https://www.holidify.com/images/cmsuploads/compressed/outdoors-human-person-adventure_20230430120633.jpg" alt="Nature Hike">
        <div class="caption">
          <h3>Nature Hike</h3>
          <p>Explore beautiful trails and breathe in the fresh mountain air.</p>
        </div>
        <label for="slide3" class="nav-btn back-btn">← Back</label>
        <label for="slide1" class="nav-btn next-btn">Next →</label>
      </div>
    </div>
  </div>
</section>


    <footer>
      <p>© 2025 Skyview Resort. All rights reserved.</p>
      <p>📞 +63 960 863 2989</p>
     
      <div class="social-links">
    <h4>Stay Connected</h4>
    <div class="icon-buttons">
      <a href="https://www.facebook.com/profile.php?id=100063647214137" target="_blank" class="icon facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="https://twitter.com" target="_blank" class="icon twitter"><i class="fab fa-twitter"></i></a>
      <a href="https://pinterest.com" target="_blank" class="icon pinterest"><i class="fab fa-pinterest-p"></i></a>
      <a href="https://www.instagram.com/islandskyview.resort/?hl=en" target="_blank" class="icon instagram"><i class="fab fa-instagram"></i></a>
      <a href="http://youtube.com/@MrBeast" target="_blank" class="icon youtube"><i class="fab fa-youtube"></i></a>
    </div>
      </div>
    </footer>
    
  </div>
</body>
</html>
