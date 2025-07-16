<?php
  require 'user/config.php';
  include("user/auth.php");

  $user_id = $_SESSION['id'];

  $stmt = $conn->prepare("SELECT checkin, checkout, room_details, created_at FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/payment.css" />
  <link rel="stylesheet" href="css/style.css" />
  <title>Payment | Skyview Resort</title>
</head>
<body>
  <!-- Radio toggles for QR selection -->
  <input type="radio" name="qr" id="qr-none" hidden checked>
  <input type="radio" name="qr" id="qr-gcash" hidden>
  <input type="radio" name="qr" id="qr-paymaya" hidden>

  <div class="wrapper">
    <header>
      <img src="images/sort.jpg" alt="Resort view" class="wrapper-bg" />
      <div class="nav">
        <h1 class="logo"><a href="index2.php">SKYVIEW</a></h1>
        <nav>
          <a href="rooms.php">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="admin/logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <main class="main-center">
      <div class="payment-container">
        <div class="payment-form">
          <h2>Complete Your Booking</h2>
          <form>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="phone">Contact Number</label>
              <input type="tel" id="phone" name="phone" required>
            </div>
            <button id="open-btn" class="btn-submit" onclick="handleOpenBtn(event)" disabled> Proceed to Payment</button>
          </form>
        </div>
      </div>
    </main>

    <footer>
      <p>© 2025 Skyview Resort. All rights reserved.</p>
      <p>📞 +63 960 863 2989</p>
    </footer>
  </div>

  <!-- Modal -->
  <div class="modal-overlay" id="pay-modal">
    <div id="modalBox" class="modal-box">
      <button id="close-btn" class="close-button" onclick="closeBtn()">&times;</button>

      <!-- QR OPTIONS -->
      <div class="qr-options">
        <h3>How would you like to pay?</h3>
        <div class="option-buttons">
          <label for="qr-gcash" class="btn">
            <img src="images/gcash.png" alt="Gcash">
            <span>Gcash</span> 
          </label>
          <label for="qr-paymaya" class="btn">
            <img src="images/maya.png" alt="PayMaya">
            <span>PayMaya</span> 
          </label>
        </div>
      </div>

      <!-- GCASH QR -->
      <div id="gcashCont" class="qr-container qr-gcash">
        <h3>Scan to pay with GCash</h3>
        <img src="images/gcash_qr.png" alt="Gcash QR Code">
        <div class="form-group" style="margin-top: 1rem;">
          <label for="gcash-receipt">Upload GCash Receipt</label>
          <input type="file" id="gcash-receipt" accept="image/*" required>
        </div>
        <label for="qr-none" class="btn-submit">Back</label>
      </div>

      <!-- PAYMAYA QR -->
      <div id="paymayaCont" class="qr-container qr-paymaya">
        <h3>Scan to pay with PayMaya</h3>
        <img src="images/maya_qr.png" alt="PayMaya QR Code">
        <div class="form-group" style="margin-top: 1rem;">
          <label for="maya-receipt">Upload PayMaya Receipt</label>
          <input type="file" id="maya-receipt" accept="image/*" required>
        </div>
        <label for="qr-none" class="btn-submit">Back</label>
      </div>
    </div>
  </div>

  <script>
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const proceedButton = document.getElementById('open-btn');

    function validateInputs() {
      const emailFilled = emailInput.value.trim() !== '';
      const phoneFilled = phoneInput.value.trim() !== '';
      proceedButton.disabled = !(emailFilled && phoneFilled);
    }

    emailInput.addEventListener('input', validateInputs);
    phoneInput.addEventListener('input', validateInputs);

    function handleOpenBtn(event) {
      event.preventDefault();
      document.getElementById('pay-modal').style.display = "flex";
    }

    function closeBtn() {
      document.getElementById('pay-modal').style.display = "none";
    }

    // Redirect after upload (simulate processing)
    function handleUploadAndRedirect(inputId) {
      const fileInput = document.getElementById(inputId);
      fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
          fileInput.disabled = true;
          fileInput.style.opacity = 0.6;
          const label = fileInput.previousElementSibling;
          if (label) label.textContent = 'Uploading...';
          setTimeout(() => {
            window.location.href = "user_booking.php";
          }, 3000);
        }
      });
    }

    handleUploadAndRedirect('gcash-receipt');
    handleUploadAndRedirect('maya-receipt');
  </script>
</body>
</html>