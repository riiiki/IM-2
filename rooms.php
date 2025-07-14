<?php 
include ("user/auth.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/jpg" href="images/skyview.jpg">
  <title>Rooms | Skyview Resort</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
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
    .welcome-text-container h2 {
      margin-top: 0;
      color: #333;
      font-size: 1.8rem;
    }
    .welcome-text-container h2 span {
      color: #007bff;
    }
    .welcome-text-container p {
      color: #555;
      line-height: 1.6;
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
    #pax-minus, #pax-plus {
      background-color: #e0e0e0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1.2rem;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    #pax-minus:hover, #pax-plus:hover {
      background-color: #d5d5d5;
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
  </style>
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="nav">
        <h1 class="logo"><a href="index2.php">SKYVIEW</a></h1>
        <nav>
          <a href="rooms.php" class="active">Rooms</a>
          <a href="user_booking.php">Bookings</a>
          <a href="activities.php">Activities</a>
          <a href="about.php">About</a>
          <a href="user/logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <main class="main-container">
      <div class="rooms-content">
        <section class="welcome-text-container">
          <h2>Our <span>Rooms</span></h2>
          <p>At Skyview Resort, we pride ourselves on offering a diverse selection of accommodations designed to meet every guest's needs and preferences. From cozy nooks to luxurious suites, Skyview offers a variety of rooms to suit every guest. Each room provides a serene escape with beautiful views, promising an experience where relaxation meets elegance.</p>
        </section>

        <section class="room-listings">
          <div class="room-card" data-room="Standard Room">
            <img src="images/double.jpeg" alt="Standard Room">
            <div class="room-details">
              <h3>Standard Room</h3>
              <p>Perfect for couples or solo travelers seeking comfort and simplicity.</p>
              <p><strong>Capacity:</strong> 2 Pax</p>
              <p><strong>Price:</strong> ₱1,500 / night</p>
              <p><strong>Rating:</strong> 7.2</p>
            </div>
          </div>

          <div class="room-card" data-room="Deluxe Room">
            <img src="images/family.jpeg" alt="Deluxe Room">
            <div class="room-details">
              <h3>Deluxe Room</h3>
              <p>Ideal for families or groups with space and comfort.</p>
              <p><strong>Capacity:</strong> 4 Pax</p>
              <p><strong>Price:</strong> ₱3,000 / night</p>
              <p><strong>Rating:</strong> 8.5</p>
            </div>
          </div>
        </section>
      </div>

      <div class="booking">
        <h3>CHECK AVAILABILITY</h3>
        <form action="user/booking.php" method="POST">
          <input type="date" name="checkin" required />
          <input type="date" name="checkout" required />

          <select name="room" id="room-select" required>
            <option value="">Select a Room</option>
            <option value="Standard Room">Standard Room</option>
            <option value="Deluxe Room">Deluxe Room</option>
          </select>

          <div style="display: flex; flex-direction: column; align-items: center; margin-top: 1rem;">
            <label style="font-weight: bold;">Additional Pax</label>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.3rem;">
              <button type="button" id="pax-minus" style="padding: 0.4rem 0.8rem;">−</button>
              <input type="number" name="pax" id="pax" value="0" min="0" max="10" required style="text-align: center; width: 60px;" />
              <button type="button" id="pax-plus" style="padding: 0.4rem 0.8rem;">+</button>
            </div>
          </div>

          <div id="price-display" style="margin-top: 10px; font-weight: bold; color: #333;"></div>

          <button type="submit" style="margin-top: 1rem;">Book Now</button>
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
    const roomSelect = document.getElementById("room-select");
    const paxInput = document.getElementById("pax");
    const display = document.getElementById("price-display");

    function getBasePrice(room) {
      if (room === "Standard Room") return 1500;
      if (room === "Deluxe Room") return 3000;
      return 0;
    }

    function updatePrice() {
      const room = roomSelect.value;
      const pax = parseInt(paxInput.value);
      const basePrice = getBasePrice(room);

      if (!room) {
        display.innerText = "";
        return;
      }

      if (isNaN(pax) || pax < 0) {
        display.innerText = `Base Price: ₱${basePrice.toLocaleString()} / night`;
        return;
      }

      const extraCost = pax * 300;
      const total = basePrice + extraCost;

      if (pax === 0) {
        display.innerText = `Total Price: ₱${total.toLocaleString()} / night (Base Only)`;
      } else {
        display.innerText = `Total Price: ₱${total.toLocaleString()} / night (₱300 x ${pax} additional pax)`;
      }
    }

    roomSelect.addEventListener("change", () => {
      paxInput.value = "0";
      updatePrice();
    });

    paxInput.addEventListener("input", updatePrice);

    document.getElementById("pax-minus").addEventListener("click", () => {
      let current = parseInt(paxInput.value) || 0;
      if (current > 0) {
        paxInput.value = current - 1;
        updatePrice();
      }
    });

    document.getElementById("pax-plus").addEventListener("click", () => {
      let current = parseInt(paxInput.value) || 0;
      if (current < 10) {
        paxInput.value = current + 1;
        updatePrice();
      }
    });

    document.querySelectorAll(".room-card").forEach(card => {
      card.addEventListener("click", () => {
        const room = card.getAttribute("data-room");
        roomSelect.value = room;
        paxInput.value = "0";
        updatePrice();
        document.querySelector(".booking").scrollIntoView({ behavior: "smooth" });
      });
    });
  </script>
</body>
</html>
