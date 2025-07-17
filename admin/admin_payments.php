<?php
include "../user/config.php";
include "header.php";

$query = "
  SELECT 
    p.*, 
    b.checkin, 
    b.checkout, 
    b.room_details, 
    b.status AS booking_status,
    c.FullName 
  FROM payments p
  JOIN bookings b ON p.booking_id = b.id
  JOIN customer c ON b.user_id = c.CustomerID
  ORDER BY p.created_at DESC
";

$result = $conn->query($query);
?>

<div class="wrapper">
  <section class="welcome">
    <h2>Payment Receipts</h2>
    <div class="table_responsive">
      <table>
        <tr>
          <th>Customer</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Method</th>
          <th>Receipt</th>
          <th>Status</th>
          <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['FullName']) ?></td>
            <td><?= htmlspecialchars($row['checkin']) ?></td>
            <td><?= htmlspecialchars($row['checkout']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['method']) ?></td>
            <td>
              <a href="../<?= htmlspecialchars($row['receipt_path']) ?>" target="_blank">View Receipt</a>
            </td>
            <td><?= htmlspecialchars($row['booking_status']) ?></td>
            <td>
              <?php if ($row['booking_status'] !== 'Confirmed'): ?>
                <form method="POST" action="confirm_payments.php">
                  <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                  <button type="submit" name="confirm" style="background: green; color: white; padding: 5px 10px; border: none; border-radius: 4px;">Confirm</button>
                </form>
              <?php else: ?>
                <span style="color: green;">✔ Confirmed</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </section>
</div>

<?php include "footer.php"; ?>
