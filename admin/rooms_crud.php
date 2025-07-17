<?php
include '../user/config.php';

// Handle CREATE new room
if (isset($_POST['create'])) {
    $name  = trim($_POST['room_name']);
    $avail = (int)$_POST['room_avail'];
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO rooms (name, availability) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $avail);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle UPDATE single room availability
if (isset($_POST['save'])) {
    $rid   = (int)$_POST['room_id'];
    $avail = (int)$_POST['availability'];
    $stmt  = $conn->prepare("UPDATE rooms SET availability = ? WHERE id = ?");
    $stmt->bind_param("ii", $avail, $rid);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle DELETE room
if (isset($_GET['delete'])) {
    $rid = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all rooms
$result = $conn->query("SELECT id, name, availability FROM rooms ORDER BY id ASC");
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Management</title>
  <link rel="stylesheet" href="css/admin_style.css">
  <style>
    .inline-form {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-edit { background-color: #007bff; color: white; }
    .btn-save { background-color: #28a745; color: white; }
    .btn-delete { background-color: #dc3545; color: white; margin-left: 8px; }
    .btn-create { background-color: #17a2b8; color: white; }
    .form-inline input {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>
  <div class="header">Admin Dashboard: Room Management</div>
  <div class="container">
    <!-- Create Room -->
    <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <input type="text"   name="room_name"  placeholder="Room Name"    required>
      <input type="number" name="room_avail" placeholder="Availability"  value="0" min="0" required>
      <button class="btn btn-create" type="submit" name="create">Add Room</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Availability</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="inline-form">
              <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
              <input type="number" name="availability" value="<?php echo $row['availability']; ?>" min="0" disabled>
              <button type="button" class="btn btn-edit">Edit</button>
              <button type="submit" name="save" class="btn btn-save" style="display:none;">Save</button>
            </form>
          </td>
          <td>
            <a class="btn btn-delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this room?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var form = btn.closest('form');
        var input = form.querySelector('input[name="availability"]');
        input.disabled = false;
        btn.style.display = 'none';
        form.querySelector('.btn-save').style.display = 'inline-block';
      });
    });
  </script>
</body>
</html>
