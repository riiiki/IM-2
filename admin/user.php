<?php
include '../user/config.php';

// INSERT NEW CUSTOMER
if (isset($_POST['add'])) {
    $name  = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $pass  = password_hash($_POST['Password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO Customer (FullName, Email, PhoneNumber, PasswordHash) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $name, $email, $phone, $pass);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// UPDATE EXISTING CUSTOMER
if (isset($_POST['update'])) {
    $id    = $_POST['CustomerID'];
    $name  = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];

    if (!empty($_POST['Password'])) {
        $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare(
            "UPDATE Customer SET FullName=?, Email=?, PhoneNumber=?, PasswordHash=? WHERE CustomerID=?"
        );
        $stmt->bind_param("ssssi", $name, $email, $phone, $pass, $id);
    } else {
        $stmt = $conn->prepare(
            "UPDATE Customer SET FullName=?, Email=?, PhoneNumber=? WHERE CustomerID=?"
        );
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
    }

    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// DELETE CUSTOMER
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Customer WHERE CustomerID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// FETCH ALL CUSTOMERS
$result = $conn->query("SELECT * FROM Customer ORDER BY DateRegistered DESC");
include "header.php";
?>

<div class="wrapper">
  <section class="welcome">
    <h2>Add New Customer</h2>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" style="margin-bottom:20px;">
      <input type="text"     name="FullName"    placeholder="Full Name"    required>
      <input type="email"    name="Email"       placeholder="Email"        required>
      <input type="text"     name="PhoneNumber" placeholder="Phone Number">
      <input type="password" name="Password"    placeholder="Password"     required>
      <button type="submit"  name="add">Add</button>
    </form>

    <h2>Registered Users</h2>
    <div class="table_responsive">
      <table>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Password (new)</th>
          <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <td>
              <input type="text" name="FullName"
                     value="<?= htmlspecialchars($row['FullName']) ?>"
                     required>
            </td>
            <td>
              <input type="email" name="Email"
                     value="<?= htmlspecialchars($row['Email']) ?>"
                     required>
            </td>
            <td>
              <input type="text" name="PhoneNumber"
                     value="<?= htmlspecialchars($row['PhoneNumber']) ?>">
            </td>
            <td>
              <input type="password" name="Password"
                     placeholder="Leave blank to keep">
            </td>
            <td>
              <input type="hidden" name="CustomerID"
                     value="<?= $row['CustomerID'] ?>">
              <button type="submit" name="update">Update</button>
              <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?delete=' . $row['CustomerID'] ?>" onclick="return confirm('Delete this customer?')">Delete</a>
            </td>
          </form>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </section>
</div>

<?php include "footer.php"; ?>
