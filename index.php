<!DOCTYPE html>
<html lang="en">

<?php
    include("./database/connection.php");
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skyview Resort</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class = "wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index.php">SKYVIEW</a></h1>
        <nav>
          <a href="explore.html">Explore</a>
          <a href="rooms.html">Rooms</a>
          <a href="activities.html">Activities</a>
          <a href="about.html">About</a>
          <a href="#" onclick="openModal('registerModal')">Register</a>
          <a href="#" onclick="openModal('loginModal')">Login</a>

        </nav>

        </nav>

        <!-- Register Modal -->
            <div id="registerModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal('registerModal')">&times;</span>
          <img src="images/logging.PNG" alt="">
          <h2>Register</h2>
          <form method="POST" action="index.php">
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

      <!-- Register Modal -->
      
      <?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    include './database/connection.php'; // Make sure connection is included here
    session_start();

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $date = $_POST['date_registered'];

    $fullName = $firstName . ' ' . $lastName;

    $stmt = $conn->prepare("INSERT INTO Customer (FullName, Email, PhoneNumber, PasswordHash, DateRegistered)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $phone, $password, $date);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id; // Get the newly inserted user ID
        $_SESSION['user_name'] = $fullName;
        header("Location: ./database/component/index2.php");
        exit(); // Make sure script stops here
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>



      <!-- Login Modal -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('loginModal')">&times;</span>
    <img src="images/logging.PNG" alt="">
    <h2>Login</h2>
    <form method="POST" action="index.php">
      <label for="login-email">Email:</label>
      <input type="email" id="login-email" name="login_email" required><br><br>

      <label for="login-password">Password:</label>
      <input type="password" id="login-password" name="login_password" required><br><br>

      <input type="submit" name="login_submit" value="Login">
    </form>
  </div>
</div>

         <!-- Login Modal -->
   <?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login_submit'])) {
    include './database/connection.php'; // Ensure connection is available
    session_start();

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT CustomerID, FullName, PasswordHash FROM Customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        if (password_verify($password, $user['PasswordHash'])) {
            $_SESSION['user_id'] = $user['CustomerID'];
            $_SESSION['user_name'] = $user['FullName'];
            header("Location: ./database/component/index2.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email.');</script>";
    }

    $stmt->close();
}
?>

      </div>
      <div class="hero">
        <img src="images/beach.jpeg" alt="Sunset Cottages" />
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
        <div class="middle-image">
          <img src="images/window.jpeg" alt="Room Window View" />
        </div>

        <div class="booking">
          <h3>BOOK NOW</h3>
          <form id="booking-form" action="booking.php" method="POST">
            <input type="date" name="check_in" placeholder="Check-in" required />
            <input type="date" name="check_out" placeholder="Check-out" required />
            <select name="room">
              <option>1 Room, 2 Adult, 0 Child</option>
              <option>1 Room, 2 Adult, 1 Child</option>
              <option>2 Room, 4 Adult, 2 Child</option>
            </select>
            <button type="submit">Check availability</button>
          </form>
          <script>
            const form = document.getElementById("booking-form");

            form.addEventListener("submit", function (e) {
              e.preventDefault();

              const formData = new FormData(form);
              console.log("Form Data:");
              console.log("Check-in:", check_in);
              console.log("Check-out:", check_out);
              console.log("Room:", room);

              form.submit();
            });
          </script>
        </div>
        </section>
    </main>

    <footer>
      <p>© 2025 Skyview Resort. All rights reserved.</p>
      <p>📞 +63 960 863 2989</p>
    </footer>

  </div>
   <script src="node.js"></script>
</body>
</html>
