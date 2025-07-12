<?php
    include("config.php");

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
        include 'config.php'; // Make sure connection is included here
        session_start();

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $date = $_POST['date_registered'];

        $fullName = $firstName . ' ' . $lastName;

        $stmt = $conn->prepare("INSERT INTO Customer (FullName, Email, PhoneNumber, PasswordHash, DateRegistered)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullName, $email, $phone, $password, $date);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id; // Get the newly inserted user ID
            $_SESSION['user_name'] = $fullName;
            header("Location: ../index2.php");
            exit(); // Make sure script stops here
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>