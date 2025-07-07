<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
  die("You must <a href='../login.php'>login</a> to book.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];
  $room = $_POST['room'];
  $user_id = $_SESSION['user']['id'];

  $stmt = $pdo->prepare("INSERT INTO bookings (user_id, checkin, checkout, room_details) VALUES (?, ?, ?, ?)");
  $stmt->execute([$user_id, $checkin, $checkout, $room]);

  echo "<h2>Booking Confirmed!</h2>";
  // echo "<a href='../user_bookings.php'>View My Bookings</a>";
}
?>
