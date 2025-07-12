<?php session_start(); ?>
<header>
  <div class="nav">
    <h1 class="logo"><a href="index.php"><span>SKYVIEW</span></a></h1>
    <nav>
      <a href="rooms.php">Rooms</a>
      <a href="user_booking.php">Bookings</a>
      <a href="activities.php">Activities</a>
      <a href="about.php">About</a>
      <a href="#" onclick="openModal('registerModal')">Register</a>
      <a href="#" onclick="openModal('loginModal')">Login</a>
    </nav>
  </div>

  <!-- Register Modal -->
  <div id="registerModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('registerModal')">&times;</span>
      <img src="images/logging.PNG" alt="">
      <h2>Register</h2>
      <form method="POST" action="../admin/handler.php">
        <input type="text" name="first_name" placeholder="First Name" required><br><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="tel" name="phone_number" placeholder="Phone Number" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="date" name="date_registered" required><br><br>
        <input type="submit" name="submit" value="Register">
      </form>
    </div>
  </div>

  <!-- Login Modal -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('loginModal')">&times;</span>
      <img src="images/logging.PNG" alt="">
      <h2>Login</h2>
      <form method="POST" action="../admin/handler.php">
        <input type="email" name="login_email" placeholder="Email" required><br><br>
        <input type="password" name="login_password" placeholder="Password" required><br><br>
        <input type="submit" name="login_submit" value="Login">
      </form>
    </div>
  </div>
</header>
