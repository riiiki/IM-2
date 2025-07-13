<?php
include '../user/config.php';

$users = $conn->query("SELECT * FROM Customer");

include "header.php";

$result = $conn->query("SELECT * FROM Customer ORDER BY DateRegistered DESC");
?>

<section class="welcome">
  <h2>Registered Users</h2>
  <div class="table_responsive">
    <table>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Date Registered</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['FullName']) ?></td>
          <td><?= $row['Email'] ?></td>
          <td><?= $row['PhoneNumber'] ?></td>
          <!-- <td><?= $row['DateRegistered'] ?></td> tentative pani siya -->
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</section>

<?php include "footer.php"; ?>
