<?php
include '../user/config.php';
include 'header.php';

// CREATE
if (isset($_POST['create'])) {
    $name     = trim($_POST['room_name']);
    $avail    = (int)$_POST['room_avail'];
    $capacity = (int)$_POST['room_capacity'];
    $price    = (float)$_POST['room_price'];

    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO rooms (name, availability, capacity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siid", $name, $avail, $capacity, $price);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// UPDATE
if (isset($_POST['save'])) {
    $rid      = (int)$_POST['room_id'];
    $avail    = (int)$_POST['availability'];
    $capacity = (int)$_POST['capacity'];
    $price    = (float)$_POST['price'];

    $stmt = $conn->prepare("UPDATE rooms SET availability = ?, capacity = ?, price = ? WHERE id = ?");
    $stmt->bind_param("iidi", $avail, $capacity, $price, $rid);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $rid = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// FETCH
$result = $conn->query("SELECT id, name, availability, capacity, price FROM rooms ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Room Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f5f9;
      margin: 0;
      padding: 20px;
    }

    .header {
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: bold;
      color: #2c3e50;
    }

    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(3, 89, 170, 1);
    }

    form.form-inline {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    form.form-inline input,
    form.form-inline button {
      padding: 8px;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 10px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #0050a0ff;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    input[type="number"] {
      width: 100px;
      padding: 5px;
    }

    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
    }

    .btn-create {
      background-color: #27ae60;
      color: white;
    }

    .btn-edit {
      background-color: #2980b9;
      color: white;
    }

    .btn-save {
      background-color: #f39c12;
      color: white;
    }

    .btn-delete {
      background-color: #e74c3c;
      color: white;
      margin-left: 5px;
    }
  </style>
</head>
<body>
  <div class="header">Admin Dashboard: Room Management</div>
  <div class="container">

    <!-- CREATE FORM -->
    <form class="form-inline" method="post" action="">
      <input type="text"   name="room_name"     placeholder="Room Name"     required>
      <input type="number" name="room_avail"    placeholder="Availability"  min="0" required>
      <input type="number" name="room_capacity" placeholder="Capacity"      min="1" required>
      <input type="number" step="0.01" name="room_price" placeholder="Price" min="0" required>
      <button class="btn btn-create" type="submit" name="create">Add Room</button>
    </form>

    <!-- TABLE -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Availability</th>
          <th>Capacity</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <form method="post" action="">
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><input type="number" name="availability" value="<?php echo $row['availability']; ?>" min="0" disabled></td>
            <td><input type="number" name="capacity"     value="<?php echo $row['capacity']; ?>" min="1" disabled></td>
            <td><input type="number" name="price" step="0.01" value="<?php echo $row['price']; ?>" min="0" disabled></td>
            <td>
              <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
              <button type="button" class="btn btn-edit">Edit</button>
              <button type="submit" name="save" class="btn btn-save" style="display:none;">Save</button>
              <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this room?')">Delete</a>
            </td>
          </form>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    document.querySelectorAll('.btn-edit').forEach(button => {
      button.addEventListener('click', function() {
        const row = this.closest('tr');
        row.querySelectorAll('input[type="number"]').forEach(input => {
          input.disabled = false;
        });
        row.querySelector('.btn-edit').style.display = 'none';
        row.querySelector('.btn-save').style.display = 'inline-block';
      });
    });
  </script>
</body>
</html>

<?php 
include 'footer.php';
?>
