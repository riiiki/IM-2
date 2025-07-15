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
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("INSERT INTO bookings (user_id, checkin, checkout, room_details) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isss", $user_id, $checkin, $checkout, $room);
  $stmt->execute();

  echo "<h2>Booking Confirmed!</h2>";
  echo "<a href='../user_bookings.php'>View My Bookings</a>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login_submit'])) {
    include 'config.php';
    session_start();

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT CustomerID, FullName, PasswordHash FROM Customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        if (password_verify($password, $user['PasswordHash'])) {
            $_SESSION['user_id'] = $user['CustomerID'];
            $_SESSION['user_name'] = $user['FullName'];
            header("Location: ../index2.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email.');</script>";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
        include 'config.php';
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
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_name'] = $fullName;
            header("Location: ../index2.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>

