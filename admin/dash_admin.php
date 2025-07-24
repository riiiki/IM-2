<?php 
  include "../user/config.php";
  include "header.php";

$result = $conn->query("
  SELECT b.id, b.checkin, b.checkout, b.room_details, b.created_at, c.fullName 
  FROM bookings b 
  LEFT JOIN customer c ON b.user_id = c.CustomerID
");

if (!$result) {
    echo "Query failed: " . $conn->error;
    exit;
}

  $bookingCount = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
  $userCount = $conn->query("SELECT COUNT(*) AS total FROM customer")->fetch_assoc()['total'];
?>

<section class="dashboard-section">
  <h2>Welcome, Admin</h2>

  <div class="dashboard-stats">
    <div class="stat-box">
      <h3>Total Users</h3>
      <p><?= $userCount ?></p>
    </div>
    <div class="stat-box">
      <h3>Total Bookings</h3>
      <p><?= $bookingCount ?></p>
    </div>
  </div>

  <h2 style="margin-top: 2rem;">All Bookings</h2>
  <div class="booking-table-container">
    <table border="1" cellpadding="10" class="styled-table">
      <thead>
        <tr>
          <th>Customer</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Room</th>
          <th>Booked On</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
          <tr>
            <td><?= htmlspecialchars($row['fullName'])?></td>
            <td><?= $row['checkin'] ?></td>
            <td><?= $row['checkout'] ?></td>
            <td><?= htmlspecialchars($row['room_details']) ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php 
  include "footer.php"; 
?>
