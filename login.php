<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  // Use your correct table and column names
  $sql = "SELECT * FROM users WHERE user_name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      // Login successful
      $_SESSION["logged_in"] = true;
      $_SESSION["username"] = $user["user_name"];
      header("Location: index.php");
      exit();
    } else {
      echo "<script>alert('Incorrect password.'); window.location.href='login.php';</script>";
    }
  } else {
    echo "<script>alert('Username not found.'); window.location.href='login.php';</script>";
  }

  $stmt->close();
  $conn->close();
}
?>

<!-- Login Form HTML -->
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-box">
    <h2>Login</h2>
    <form action="login.php" method="POST"autocomplete="off">
      <label>Username</label>
      <input type="text" name="username" required autocomplete="off">

      <label>Password</label>
     <input type="password" name="password" required autocomplete="new-password">

      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
