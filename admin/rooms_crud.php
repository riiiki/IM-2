<?php
include '../user/config.php';

// Handle CREATE new room
if (isset($_POST['create'])) {
    $name = trim($_POST['room_name']);
    $avail = (int)$_POST['room_avail'];
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO rooms (name, availability) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $avail);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']); exit;
}

// Handle UPDATE availability
if (isset($_POST['update'])) {
    foreach ($_POST['availability'] as $id => $val) {
        $stmt = $conn->prepare("UPDATE rooms SET availability = ? WHERE id = ?");
        $avail = (int)$val;
        $rid = (int)$id;
        $stmt->bind_param("ii", $avail, $rid);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']); exit;
}

// Handle DELETE room
if (isset($_GET['delete'])) {
    $rid = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']); exit;
}

// Fetch all rooms
$result = $conn->query("SELECT id, name, availability FROM rooms ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Room CRUD</title>
  <style>
    body {margin:0;padding:0;font-family:Arial,sans-serif;background:#f4f7fa;color:#333;}
    .header {background:#007bff;color:#fff;padding:20px;text-align:center;font-size:1.8rem;}
    .container {max-width:800px;margin:40px auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);overflow-x:auto;}
    table {width:100%;border-collapse:collapse;text-align:center;}
    th,td {padding:12px;border-bottom:1px solid #ddd;}
    th {background:#f0f0f0;font-size:1rem;}
    .actions {text-align:center;margin-top:20px;}
    .btn {padding:6px 12px;border:none;border-radius:4px;cursor:pointer;}
    .btn-update {background:#28a745;color:#fff;}
    .btn-delete {background:#dc3545;color:#fff;}
    .btn-create {background:#007bff;color:#fff;}
    .form-inline {display:flex;gap:8px;align-items:center;justify-content:center;margin-bottom:20px;}
    .form-inline input[type="text"], .form-inline input[type="number"] {padding:6px;border:1px solid #ccc;border-radius:4px;}
    .availability input {width:60px;text-align:center;}
  </style>
</head>
<body>
  <div class="header">Admin Dashboard: Room Management</div>
  <div class="container">
    <!-- Create Room -->
    <form class="form-inline" method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>">
      <input type="text" name="room_name" placeholder="Room Name" required>
      <input type="number" name="room_avail" placeholder="Availability" value="0" min="0" required>
      <button class="btn btn-create" type="submit" name="create">Add Room</button>
    </form>

    <form method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>">
      <table>
        <thead>
          <tr><th>ID</th><th>Name</th><th>Availability</th><th>Delete</th></tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td class="availability">
              <input type="number" name="availability[<?= $row['id'] ?>]" value="<?= $row['availability'] ?>" min="0">
            </td>
            <td>
              <a class="btn btn-delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this room?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
      <div class="actions">
        <button class="btn btn-update" type="submit" name="update">Save Changes</button>
      </div>
    </form>
  </div>
</body>
</html>
