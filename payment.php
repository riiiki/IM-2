<?php
require 'user/config.php';
include("user/auth.php");

$user_id = $_SESSION['id'];

// Expect `booking_id` from user_booking.php
if (!isset($_GET['id'])) {
  echo "<script>alert('Invalid access.'); window.location.href='user_booking.php';</script>";
  exit();
}

$id = intval($_GET['id']);

// Fetch booking
$stmt = $conn->prepare("SELECT checkin, checkout, room_details, created_at FROM bookings WHERE user_id = ? AND id = ?");
$stmt->bind_param("ii", $user_id, $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  echo "<script>alert('Booking not found or unauthorized.'); window.location.href='user_booking.php';</script>";
  exit();
}

$booking = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment | Skyview Resort</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/payment.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

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
        <h2>Complete Your Booking Payment</h2>
        <form id="userForm">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Contact Number</label>
            <input type="tel" id="phone" name="phone" required>
          </div>
          <input type="hidden" id="bookingIdField" value="<?= htmlspecialchars($id) ?>">

          <button id="open-btn" class="btn-submit" onclick="handleOpenBtn(event)" disabled>Proceed to Payment</button>
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

    <!-- Shared Form for both QR methods -->
    <form id="receiptForm" action="upload_receipt.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="booking_id" id="form-booking-id">
  <input type="hidden" name="method" id="methodField">
  <input type="hidden" name="email" id="form-email">
  <input type="hidden" name="phone" id="form-phone">

  <!-- QR View -->
  <div id="gcashCont" class="qr-container qr-gcash">
    <h3>Scan to pay with GCash</h3>
    <img src="images/gcash_qr.png" alt="Gcash QR Code">
  </div>

  <div id="paymayaCont" class="qr-container qr-paymaya">
    <h3>Scan to pay with PayMaya</h3>
    <img src="images/maya_qr.png" alt="PayMaya QR Code">
  </div>

  <!-- Receipt Upload Area (Shown dynamically) -->
  <div class="form-group" id="upload-section" style="display:none;">
    <label id="upload-label">Upload Receipt</label>
    <input type="file" name="receipt" id="receiptInput" accept="image/*" required>
    <button type="submit" class="btn-submit">Upload & Confirm</button>
    <label for="qr-none" class="btn-submit">Back</label>
  </div>
</form>

  </div>
</div>

<script>
  const emailInput = document.getElementById('email');
  const phoneInput = document.getElementById('phone');
  const proceedButton = document.getElementById('open-btn');

  function validateInputs() {
    proceedButton.disabled = !(emailInput.value.trim() && phoneInput.value.trim());
  }

  emailInput.addEventListener('input', validateInputs);
  phoneInput.addEventListener('input', validateInputs);

  function handleOpenBtn(event) {
    event.preventDefault();
    const email = emailInput.value.trim();
    const phone = phoneInput.value.trim();
    const bookingId = document.getElementById('bookingIdField').value;

    if (!email || !phone) {
      alert("Please fill out email and phone.");
      return;
    }

    document.getElementById('form-email').value = email;
    document.getElementById('form-phone').value = phone;
    document.getElementById('form-booking-id').value = bookingId;

    document.getElementById('pay-modal').style.display = "flex";
  }

  document.querySelectorAll('input[name="qr"]').forEach(input => {
    input.addEventListener('change', () => {
      const method = input.id.replace('qr-', '');
      document.getElementById('methodField').value = method;
    });
  });

  function closeBtn() {
    document.getElementById('pay-modal').style.display = "none";
  }
  function showUploadSection(method) {
  const uploadSection = document.getElementById("upload-section");
  const gcashCont = document.getElementById("gcashCont");
  const paymayaCont = document.getElementById("paymayaCont");

  uploadSection.style.display = "block";

  if (method === "gcash") {
    gcashCont.style.display = "block";
    paymayaCont.style.display = "none";
  } else if (method === "paymaya") {
    gcashCont.style.display = "none";
    paymayaCont.style.display = "block";
  }
}

document.querySelectorAll('input[name="qr"]').forEach(input => {
  input.addEventListener('change', () => {
    const method = input.id.replace('qr-', '');
    document.getElementById('methodField').value = method;
    showUploadSection(method);
  });
});

</script>

</body>
</html>
