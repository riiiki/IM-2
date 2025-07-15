<?php
    include("config.php");
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login_submit'])) {
    include 'config.php';
    session_start();

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT CustomerID, FullName, PasswordHash FROM Customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        if (password_verify($password, $user['PasswordHash'])) {
            $_SESSION['user_id'] = $user['CustomerID'];
            $_SESSION['user_name'] = $user['FullName'];
            header("Location: ../index2.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email.');</script>";
    }

    $stmt->close();
}
?>