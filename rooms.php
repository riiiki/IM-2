<?php
include("user/auth.php");
include("user/config.php");

// Fetch rooms from DB
$rooms = [];
$result = $conn->query("SELECT id, name, availability, image_path FROM rooms");
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

// Today's date for disabling past dates
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/png" href="images/mountain.png">
  <title>Rooms | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    /* Inline styling moved here from your previous code */
    .rooms-content {
      display: flex;
      justify-content: center;
      gap: 2rem;
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
      align-items: flex-start;
    }
    .welcome-text-container {
      flex: 1;
      max-width: 350px;
      padding: 1.5rem;
      background-color: #f0f8ff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      align-self: stretch;
    }
    .room-listings {
      flex: 2;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 2rem;
    }
    .room-card {
      display: flex;
      flex-direction: column;
      border: 1px solid #ddd;
      border-radius: 12px;
      overflow: hidden;
      width: 300px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      background-color: #fff;
      transition: transform 0.3s ease;
      min-height: 400px;
      cursor: pointer;
    }
    .room-card:hover {
      transform: scale(1.02);
    }
    .room-card.unavailable {
      opacity: 0.5;
      cursor: not-allowed;
    }
    .room-card.unavailable:hover {
      transform: none;
    }
    .room-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .room-details {
      padding: 1rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .room-details h3 {
      margin-top: 0;
      font-size: 1.4rem;
      color: #333;
    }
    .room-details p {
      margin: 0.4rem 0;
      color: #555;
    }
    .booking {
      text-align: center;
      margin: 2rem auto;
      max-width: 400px;
      background-color: #f9f9f9;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .booking h3 {
      margin-bottom: 1rem;
    }
    .booking form {
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
    }
    .booking input, .booking select, .booking button {
      padding: 0.7rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    .booking button {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .booking button:hover {
      background-color: #388E3C;
    }
    main.main-container {
      padding-bottom: 4rem;
    }
    @media (max-width: 992px) {
      .rooms-content {
        flex-direction: column;
        align-items: center;
      }
      .welcome-text-container, .room-listings {
        max-width: 100%;
        flex: none;
        width: 90%;
      }
      .room-listings {
        margin-top: 1.5rem;
      }
    }
    @media (max-width: 768px) {
      .room-card {
        width: 100%;
        max-width: 350px;
      }
    }
    #availability-msg {
      color: red;
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <header>
    <div class="nav">
      <h1 class="logo"><a href="index.php">SKYVIEW</a></h1>
      <nav>
        <a href="rooms.php">Rooms</a>
        <a href="user_booking.php">Bookings</a>
        <a href="activities.php">Activities</a>
        <a href="about.php">About</a>
        <span>Welcome, <?php echo htmlspecialchars($loginUsername); ?>!</span>
        <a href="admin/logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main class="main-container">
    <div class="rooms-content">
      <section class="welcome-text-container">
        <h2 class="welcome-title">Explore Our Rooms</h2>
        <p class="welcome-text">Choose from our available rooms and book your stay with Skyview Resort.</p>
      </section>

      <section class="room-listings">
        <?php foreach ($rooms as $room): ?>
          <div class="room-card <?= $room['availability'] <= 0 ? 'unavailable' : '' ?>"
               data-id="<?= $room['id'] ?>" data-name="<?= htmlspecialchars($room['name']) ?>">
            <img src="<?= htmlspecialchars($room['image_path']) ?>" alt="<?= htmlspecialchars($room['name']) ?>">
            <div class="room-details">
              <h3><?= htmlspecialchars($room['name']) ?></h3>
              <p><strong>Availability:</strong> <?= $room['availability'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    </div>

    <div class="booking">
      <h3>CHECK AVAILABILITY</h3>
      <form action="user/booking.php" method="POST">
        <input type="date" name="checkin" id="checkin" required min="<?= $today ?>" />
        <input type="date" name="checkout" id="checkout" required min="<?= $today ?>" />
        
        <!-- Select using room_id -->
        <select name="room_id" id="room-select" required>
          <option value="">Select a Room</option>
          <?php foreach ($rooms as $room): ?>
            <option value="<?= $room['id'] ?>" <?= $room['availability'] == 0 ? 'disabled' : '' ?>>
              <?= htmlspecialchars($room['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label style="font-weight:bold; margin-top:1rem">Additional Pax</label>
        <div style="display:flex; align-items:center; gap:0.5rem">
          <button type="button" id="pax-minus">−</button>
          <input type="number" name="pax" id="pax" value="0" min="0" max="10" required style="width:60px; text-align:center;" />
          <button type="button" id="pax-plus">+</button>
        </div>
        <div id="availability-msg"></div>
        <button type="submit" style="margin-top:1rem;">Book Now</button>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 Skyview Resort. All rights reserved.</p>
    <p>📞 +63 960 863 2989</p>
    <div class="social-links">
      <h4>Stay Connected</h4>
      <div class="icon-buttons">
        <a href="https://www.facebook.com/profile.php?id=100063647214137" target="_blank" class="icon facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com" target="_blank" class="icon twitter"><i class="fab fa-twitter"></i></a>
        <a href="https://ph.pinterest.com/pin/30328997485654246/" target="_blank" class="icon pinterest"><i class="fab fa-pinterest-p"></i></a>
        <a href="https://www.instagram.com/islandskyview.resort/?hl=en" target="_blank" class="icon instagram"><i class="fab fa-instagram"></i></a>
        <a href="http://youtube.com/@MrBeast" target="_blank" class="icon youtube"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </footer>
</div>

<script>
  const rooms = <?= json_encode($rooms) ?>;
  const today = new Date().toISOString().split('T')[0];
  const checkin = document.getElementById('checkin');
  const checkout = document.getElementById('checkout');
  const roomSelect = document.getElementById("room-select");
  const availabilityMsg = document.getElementById("availability-msg");
  const paxInput = document.getElementById("pax");

  checkin.min = today;
  checkout.min = today;

  checkin.addEventListener('change', () => {
    checkout.min = checkin.value || today;
    if (checkout.value < checkout.min) {
      checkout.value = checkout.min;
    }
  });

  roomSelect.addEventListener("change", () => {
    availabilityMsg.innerText = "";
    const selectedId = parseInt(roomSelect.value);
    const selectedRoom = rooms.find(r => r.id === selectedId);
    if (selectedRoom && selectedRoom.availability <= 0) {
      availabilityMsg.innerText = "This room is currently unavailable.";
    }
  });

  document.querySelectorAll('.room-card').forEach(card => {
    card.addEventListener('click', () => {
      if (card.classList.contains('unavailable')) return;
      roomSelect.value = card.dataset.id;
      roomSelect.dispatchEvent(new Event('change'));
      document.querySelector('.booking').scrollIntoView({ behavior: 'smooth' });
    });
  });

  document.getElementById("pax-minus").addEventListener("click", () => {
    if (parseInt(paxInput.value) > 0) {
      paxInput.value = parseInt(paxInput.value) - 1;
    }
  });
  document.getElementById("pax-plus").addEventListener("click", () => {
    if (parseInt(paxInput.value) < 10) {
      paxInput.value = parseInt(paxInput.value) + 1;
    }
  });
</script>
</body>
</html>
