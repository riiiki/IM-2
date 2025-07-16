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

include 'header.php';

?>


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
    </form>
  </div>
</body>
</html>
