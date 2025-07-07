// CREATE DATABASE skyview;

// USE skyview;

// CREATE TABLE bookings (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   checkin DATE NOT NULL,
//   checkout DATE NOT NULL,
//   room_details VARCHAR(255) NOT NULL,
//   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );
// mao ni sud sa db e tweak lang nya


<?php
session_start();

if(!isset($_SESSION['admin'])){
  header("Location: login.php"); //ilisi nya ni ug unsa atong name sa login file pls
  exit();
}

require 'config.php';

$stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; border: 1px solid #ccc; }
  </style>
</head>
<body>
  <h2>Skyview Bookings</h2>
  <a href="logout.php">Logout</a>

  <?php if (empty($bookings)): ?>
    <p>No bookings found.</p>
  <?php else: ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Room Details</th>
        <th>Created At</th>
      </tr>
      <?php foreach ($bookings as $booking): ?>
        <tr>
          <td><?= $booking['id'] ?></td>
          <td><?= $booking['checkin'] ?></td>
          <td><?= $booking['checkout'] ?></td>
          <td><?= htmlspecialchars($booking['room_details']) ?></td>
          <td><?= $booking['created_at'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</body>
</html>


