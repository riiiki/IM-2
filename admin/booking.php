<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $checkin = $_POST['check_in'] ?? '';
        $checkout = $_POST['check_out'] ?? '';
        $room = $_POST['room'] ?? '';

        echo "<h2>Thank you for booking at Skyview Resort!</h2>";
        echo "<a href='index.html'>Back to Home</a>";
    } else {
        header("Location: index.html");
        exit();
    }
?>
