<?php
session_start();

// Clear all session data
session_unset();
session_destroy();

// Prevent browser from using cached session data
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Redirect to homepage
header("Location: index.php");
exit;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Logged Out</title>
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="refresh" content="2;url=index.php">
</head>
<body>
  <div class="logout-box">
    <h2>You have been logged out.</h2>
    <p>Redirecting to homepage...</p>
  </div>
</body>
</html>
