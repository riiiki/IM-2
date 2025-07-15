<?php
include '../user/config.php';
include "header.php";

$result = $conn->query("SELECT * FROM bookings INNER JOIN Customer ON bookings.user_id = Customer.CustomerID ORDER BY checkin DESC");
?>

<div class="wrapper">
  <section class="welcome">
    <h2>All Bookings</h2>
    <div class="table_responsive">
      <table>
        <tr>
          <th>Customer</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Room</th>
          <th>Booked On</th>
          <th>Status</th>
        </tr>
        <?php
          while ($row = $result->fetch_assoc()): 
        ?>
          <tr>
            <td><?= htmlspecialchars($row['FullName']) ?></td>
            <td><?= $row['checkin'] ?></td>
            <td><?= $row['checkout'] ?></td>
            <td><?= $row['room_details'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <!-- <td>  </td> -->
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </section>
</div>

<?php 
  include "footer.php"; 
?>
