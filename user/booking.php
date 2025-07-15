<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
  die("You must <a href='../index.php'>login</a> to book.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];
  $room = $_POST['room'];
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("INSERT INTO bookings (user_id, checkin, checkout, room_details) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isss", $user_id, $checkin, $checkout, $room);
  if ($stmt->execute()) {
        echo "<script>
            alert('Booking confirmed!');
            window.location.href = '../user_booking.php';
        </script>";
    } else {
        echo "<script>
            alert('Booking failed: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

  echo "<h2>Booking Confirmed!</h2>";
  echo "<a href='../user_bookings.php'>View My Bookings</a>";
}
?>
