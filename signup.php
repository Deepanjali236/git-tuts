<?php
session_start();

// Show all errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include DB connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize inputs
  $username = htmlspecialchars(trim($_POST["username"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $password = htmlspecialchars(trim($_POST["password"]));
  // $referral = htmlspecialchars(trim($_POST["referral"])); // Removed

  // Gmail validation
  if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\\.com$/", $email)) {
    echo "<script>alert('Only Gmail addresses are allowed.'); window.location.href='signup.php';</script>";
    exit();
  }

  // Check if username exists
  $check_sql = "SELECT * FROM users WHERE user_name = ?";
  $stmt = $conn->prepare($check_sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('Username already taken.'); window.location.href='signup.php';</script>";
    exit();
  }

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert new user WITHOUT referral
  $insert_sql = "INSERT INTO users (user_name, email, password) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($insert_sql);
  $stmt->bind_param("sss", $username, $email, $hashed_password);

  if ($stmt->execute()) {
    $_SESSION["logged_in"] = true;
    $_SESSION["username"] = $username;
    header("Location: index.php");
    exit();
  } else {
    echo "<script>alert('Signup failed. Try again.'); window.location.href='signup.php';</script>";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="signup-box">
    <h2>Signup</h2>
    <form action="signup.php" method="POST" autocomplete="off">

      <label>Username</label>
      <input type="text" name="username" required autocomplete="off">

      <label>Email (Gmail only)</label>
      <input type="email" name="email" required autocomplete="off">

      <label>Password</label>
      <input type="password" name="password" required autocomplete="new-password">

      <label>How did you know about us?</label>
      <select name="referral" required>
        <option value="">--Select--</option>
        <option value="Google">Google</option>
        <option value="Facebook">Facebook</option>
        <option value="Ad">Ad</option>
        <option value="Friends">Friends</option>
        <option value="Instagram">Instagram</option>
        <option value="Others">Others</option>
      </select>

      <button type="submit">Signup</button>
    </form>
  </div>
</body>
</html>
