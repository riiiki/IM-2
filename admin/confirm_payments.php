<?php
include "../user/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $booking_id = intval($_POST['booking_id']);

    // Confirm booking
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Confirmed' WHERE id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
      
        // if needed rani (update the payments table)
        // $conn->query("UPDATE payments SET status = 'Confirmed' WHERE booking_id = $booking_id");

        echo "<script>alert('✅ Booking confirmed successfully.'); window.location.href='admin_payments.php';</script>";
    } else {
        echo "❌ Failed to confirm booking: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ Invalid request.";
}
?>
