<?php
session_start();
include "../connection.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$loggedInUserId = $_SESSION['user_id'];

// Get full name
$stmt = $conn->prepare("SELECT FullName FROM Customer WHERE CustomerID = ?");
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $loginUsername = $row['FullName'];
} else {
    $loginUsername = "Guest";
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skyview Resort</title>
  <link rel="stylesheet" href="../../style.css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="#">SKYVIEW</a></h1>
        <nav>
          <a href="explore.html">Explore</a>
          <a href="rooms.html">Rooms</a>
          <a href="activities.html">Activities</a>
          <a href="about.html">About</a>
          <span>Welcome, <?php echo htmlspecialchars($loginUsername); ?>!</span>
          <a href="../../index.php">Logout</a>
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
        <div class="middle-image">
          <img src="../../images/window.jpeg" alt="Room Window View" />
        </div>

        <div class="booking">
          <h3>BOOK NOW</h3>
          <form id="booking-form" action="booking.php" method="POST">
            <input type="date" name="check_in" required />
            <input type="date" name="check_out" required />
            <select name="room">
              <option>1 Room, 2 Adult, 0 Child</option>
              <option>1 Room, 2 Adult, 1 Child</option>
              <option>2 Room, 4 Adult, 2 Child</option>
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
