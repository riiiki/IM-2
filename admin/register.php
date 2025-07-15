<?php
session_start();
include("../user/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkStmt = $conn->prepare("SELECT * FROM Customer WHERE Email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Email already registered.'); window.location.href='register.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO Customer (FullName, Email, PhoneNumber, PasswordHash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $phone, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. You can now log in.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error during registration.'); window.location.href='register.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Skyview Resort</title>
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body class="wrapper-admin">
  <div class="login_container">
    <h2>Register as a Guest</h2>
    <form method="POST" action="register.php">
      <input type="text" name="fullname" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="tel" name="phone" placeholder="Phone Number" required pattern="[0-9+ ]{7,}" />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
