<?php
include("user/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $method = $_POST['method'];

    $uploadDir = "receipt_uploads/";
    $receiptPathForBrowser = "receipt_uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $ext = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $fileName = "receipt_" . uniqid() . "." . $ext;
        $uploadPath = $uploadDir . $fileName;
        $receiptURL = $receiptPathForBrowser . $fileName;

        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadPath)) {
            // Save to payments table
            $stmt = $conn->prepare("INSERT INTO payments (booking_id, email, phone, method, receipt_path, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("issss", $booking_id, $email, $phone, $method, $receiptURL);

            if ($stmt->execute()) {
                // Update booking status
                $update = $conn->prepare("UPDATE bookings SET status = 'Awaiting Confirmation' WHERE id = ?");
                $update->bind_param("i", $booking_id);
                $update->execute();

                echo "<script>alert('✅ Receipt uploaded successfully! Waiting for admin confirmation.'); window.location.href='user_booking.php';</script>";
            } else {
                echo "❌ Database error: " . $stmt->error;
            }
        } else {
            echo "❌ Failed to move uploaded file.";
        }
    } else {
        echo "❌ Please upload a receipt file.";
    }
}
?>
