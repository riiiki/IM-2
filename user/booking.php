<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("You must <a href='../index.php'>login</a> to book.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $room_id = $_POST['room_id'] ?? null;
    $user_id = $_SESSION['id'];

    // Check if room_id is valid
    if (!$room_id) {
        echo "<script>
            alert('Please select a room.');
            window.history.back();
        </script>";
        exit;
    }

    // Fetch the room name from the database
    $stmt = $conn->prepare("SELECT name FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
            alert('Selected room does not exist.');
            window.history.back();
        </script>";
        exit;
    }

    $room_data = $result->fetch_assoc();
    $room_name = $room_data['name'];

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, checkin, checkout, room_details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $checkin, $checkout, $room_name);

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
}
?>
