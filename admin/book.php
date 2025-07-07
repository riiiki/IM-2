<?php
require 'admin/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];
  $room = $_POST['room'];

  $stmt = $pdo->prepare("INSERT INTO bookings (checkin, checkout, room_details) VALUES (?, ?, ?)");
  $stmt->execute([$checkin, $checkout, $room]);

  echo "<h2>Booking confirmed!</h2>";
  echo "<a href = 'index.html'>Back to Home</a>";
}
?>
