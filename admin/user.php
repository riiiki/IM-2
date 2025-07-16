<?php
// Only start session if none exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../user/config.php';

// INSERT NEW CUSTOMER
if (isset($_POST['add'])) {
    $name  = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $pass  = password_hash($_POST['Password'], PASSWORD_DEFAULT);

    if (empty($email)) {
        die("Email cannot be empty.");
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT CustomerID FROM Customer WHERE Email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("This email is already registered.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO Customer (FullName, Email, PhoneNumber, PasswordHash) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $name, $email, $phone, $pass);
    $stmt->execute();

    $_SESSION['message'] = "Customer added successfully.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// UPDATE CUSTOMER DETAILS
if (isset($_POST['update_details'])) {
    $id    = $_POST['CustomerID'];
    $name  = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];

    $stmt = $conn->prepare(
        "UPDATE Customer SET FullName=?, Email=?, PhoneNumber=? WHERE CustomerID=?"
    );
    $stmt->bind_param("sssi", $name, $email, $phone, $id);
    $stmt->execute();

    $_SESSION['message'] = "Details updated successfully.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// UPDATE CUSTOMER PASSWORD
if (isset($_POST['update_password'])) {
    $id    = $_POST['CustomerID'];
    $pass  = $_POST['Password'];
    if (!empty($pass)) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE Customer SET PasswordHash = ? WHERE CustomerID = ?");
        $stmt->bind_param("si", $hash, $id);
        $stmt->execute();

        $_SESSION['message'] = "Password updated successfully.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// DELETE CUSTOMER
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $delBookings = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
    $delBookings->bind_param("i", $id);
    $delBookings->execute();
    $delBookings->close();

    $delCustomer = $conn->prepare("DELETE FROM Customer WHERE CustomerID = ?");
    $delCustomer->bind_param("i", $id);
    if ($delCustomer->execute()) {
        $_SESSION['message'] = "Customer deleted successfully.";
    } else {
        $_SESSION['message'] = "Could not delete customer.";
    }
    $delCustomer->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$result = $conn->query("SELECT * FROM Customer ORDER BY DateRegistered DESC");
include "header.php";
?>

<style>
  .notification {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: #28a745;
    color: white;
    padding: 12px 24px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }
  .notification.show {
    opacity: 1;
  }

  .table_responsive {
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    padding: 12px;
    border-bottom: 1px solid #ccc;
    text-align: left;
  }

  th {
    background: #f0f0f0;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  .form-inline {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 20px;
  }

  .form-inline input,
  .form-inline button {
    width: 220px;
    padding: 8px;
    font-size: 14px;
    border-radius: 4px;
  }

  button {
    padding: 8px 16px;
    margin: 2px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background 0.3s ease;
  }

  .edit-btn { background: #007bff; color: white; }
  .edit-btn:hover { background: #0056b3; }

  .change-pass-btn { background: #ffc107; color: #333; }
  .change-pass-btn:hover { background: #e0a800; }

  .save-details-btn { background: #28a745; color: white; }
  .save-details-btn:hover { background: #218838; }

  .save-pass-btn { background: #17a2b8; color: white; }
  .save-pass-btn:hover { background: #117a8b; }

  .delete-link {
    color: #dc3545;
    text-decoration: none;
    font-weight: bold;
  }

  .delete-link:hover {
    text-decoration: underline;
  }

  form > button[name="add"] {
    background: #28a745;
    color: white;
  }

  form > button[name="add"]:hover {
    background: #218838;
  }
</style>

<div class="wrapper">
  <?php if (isset($_SESSION['message'])): ?>
    <div id="toast" class="notification"><?= $_SESSION['message'] ?></div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <section class="welcome">
    <h2>Add New Customer</h2>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="form-inline">
      <input type="text" name="FullName" placeholder="Full Name" required>
      <input type="email" name="Email" placeholder="Email" required>
      <input type="text" name="PhoneNumber" placeholder="Phone Number">
      <input type="password" name="Password" placeholder="Password" required>
      <button type="submit" name="add">Add</button>
    </form>

    <h2>Registered Users</h2>
    <div class="table_responsive">
      <table>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>New Password</th>
          <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr data-id="<?= $row['CustomerID'] ?>">
          <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <td><input type="text" name="FullName" value="<?= htmlspecialchars($row['FullName']) ?>" required disabled></td>
            <td><input type="email" name="Email" value="<?= htmlspecialchars($row['Email']) ?>" required disabled></td>
            <td><input type="text" name="PhoneNumber" value="<?= htmlspecialchars($row['PhoneNumber']) ?>" disabled></td>
            <td><input type="password" name="Password" placeholder="Leave blank if N/A" disabled></td>
            <td>
              <input type="hidden" name="CustomerID" value="<?= $row['CustomerID'] ?>">
              <button type="button" class="edit-btn">Edit</button>
              <button type="submit" name="update_details" class="save-details-btn" style="display:none;">Save</button>
              <button type="button" class="change-pass-btn">Change Password</button>
              <button type="submit" name="update_password" class="save-pass-btn" style="display:none;">Save Password</button>
              <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?delete=' . $row['CustomerID'] ?>" class="delete-link" onclick="return confirm('Delete this customer?')">Delete</a>
            </td>
          </form>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </section>
</div>

<script>
  // Edit details
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const row = btn.closest('tr');
      row.querySelectorAll("input[name='FullName'], input[name='Email'], input[name='PhoneNumber']").forEach(i => i.disabled = false);
      btn.style.display = 'none';
      row.querySelector('.save-details-btn').style.display = 'inline-block';
    });
  });

  // Change password
  document.querySelectorAll('.change-pass-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const row = btn.closest('tr');
      const pw = row.querySelector("input[name='Password']");
      pw.disabled = false;
      pw.focus();
      btn.style.display = 'none';
      row.querySelector('.save-pass-btn').style.display = 'inline-block';
    });
  });

  // Toast Notification
  const toast = document.getElementById('toast');
  if (toast) {
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => toast.classList.remove('show'), 3500);
    setTimeout(() => toast.remove(), 4000);
  }
</script>

<?php include 'footer.php'; ?>
