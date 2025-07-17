<?php
include("user/auth.php");
include("user/config.php");

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    echo "<script>alert('Please log in to view your bookings.'); window.location.href='admin/login.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT id, checkin, checkout, room_details, created_at, status FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Bookings | Skyview Resort</title>
  <link rel="stylesheet" href="css/admin_style.css" />
  <link rel="icon" type="image/png" href="images/mountain.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="wrapper">
  <header>
    <div class="nav">
      <h1 class="logo"><a href="index2.php"><span>SKYVIEW</span></a></h1>
      <nav>
        <a href="rooms.php">Rooms</a>
        <a href="user_booking.php" class="active">Bookings</a>
        <a href="activities.php">Activities</a>
        <a href="about.php">About</a>
        <span>Welcome, <?php echo htmlspecialchars($loginUsername); ?>!</span>
        <a href="admin/logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <section class="hero">
    <img src="images/sort.jpg" alt="Bookings Banner">
    <div class="hero-text">My Bookings</div>
  </section>

  <main class="main-container">
    <div class="booking" style="width: 100%; max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center;">
      <h3 style="text-align:center;">My Bookings</h3>

      <?php if ($result->num_rows > 0): ?>
        <div class="booking-table-container" style="width: 100%;">
          <table border="1" cellpadding="10" class="styled-table" style="width: 100%; text-align: center;">
            <thead>
              <tr>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Room</th>
                <th>Booked On</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['checkin']); ?></td>
                  <td><?= htmlspecialchars($row['checkout']); ?></td>
                  <td><?= htmlspecialchars($row['room_details']); ?></td>
                  <td><?= htmlspecialchars($row['created_at']); ?></td>
                  <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                      <!-- Show payment button if still pending -->
                      <div style="display: flex; flex-direction: column; align-items: center;">
                        <span style="color: #ff9800; font-weight: bold;">Pending</span>
                        <form action="payment.php" method="GET" style="margin-top: 5px;">
                          <input type="hidden" name="id" value="<?= $row['id']; ?>">
                          <button type="submit" style="padding: 6px 14px; background-color:  #003366; color: #fff; border: none; border-radius: 5px; font-size: 13px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor=' #135089ff';" onmouseout="this.style.backgroundColor='#003366';">
                            Proceed to Payment
                          </button>
                        </form>
                      </div>

                    <?php elseif ($row['status'] === 'Awaiting Confirmation'): ?>
                      <!-- Waiting for admin to verify -->
                      <span style="color: orange; font-weight: bold;">Awaiting Confirmation</span>

                    <?php elseif ($row['status'] === 'Paid'): ?>
                      <!-- Payment approved -->
                      <span style="color: #4CAF50; font-weight: bold;">Paid</span>

                    <?php else: ?>
                      <!-- Unknown status fallback -->
                      <span style="color: green; font-weight: bold;"><?= htmlspecialchars($row['status']); ?></span>
                    <?php endif; ?>
                  </td>
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
