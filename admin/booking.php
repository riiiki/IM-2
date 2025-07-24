<?php 
include "../user/config.php";
include "header.php";

$result = $conn->query("
  SELECT b.id, b.checkin, b.checkout, b.room_details, b.created_at, b.status, c.FullName 
  FROM bookings b 
  LEFT JOIN customer c ON b.user_id = c.CustomerID
  ORDER BY b.checkin DESC
");
?>

<div class="wrapper">
  <section class="welcome">
    <h2>All Bookings</h2>
    <div class="table_responsive">
       <a href="admin_payments.php" style="
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 15px;
    ">
      View All Payment Receipts
    </a>
      <table>
        <tr>
          <th>Customer</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Room</th>
          <th>Booked On</th>
          <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['FullName']) ?></td>
            <td><?= htmlspecialchars($row['checkin']) ?></td>
            <td><?= htmlspecialchars($row['checkout']) ?></td>
            <td><?= htmlspecialchars($row['room_details']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td>
              <?= htmlspecialchars($row['status'] ?? 'Pending') ?>

              <?php
                $bookingId = $row['id'];
                $paymentResult = $conn->query("SELECT id FROM payments WHERE booking_id = $bookingId");
                if ($payment = $paymentResult->fetch_assoc()) {
                  echo '<br><a href="admin_payments.php?booking_id=' . $bookingId . '" class="btn btn-sm" style="margin-top: 5px; display: inline-block; background: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px;">View Receipt</a>';
                }
              ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </section>
</div>

<?php include "footer.php"; ?>
