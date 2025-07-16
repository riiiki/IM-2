<?php
if (session_status() === PHP_SESSION_NONE) { 
    session_start();
}
include("../user/config.php"); '../user/config.php';

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel - Skyview Resort</title>
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body class="admin">
<div class="wrapper-admin">
  <header>
    <div class="nav">
      <h1 class="logo"><a href="dash_admin.php">SKYVIEW</a></h1>
      <nav>
        <a href="dash_admin.php">Dashboard</a>
        <a href="rooms_crud.php">Rooms</a>
        <a href="booking.php">Bookings</a>
        <a href="user.php">Users</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>
  <main class="main-container">
