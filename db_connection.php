<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "registration_db";

$conn = new mysqli($servername, $username, $password, $database);

// Handle error clearly
if ($conn->connect_error) {
  die(json_encode(["success" => false, "message" => "DB connection failed: " . $conn->connect_error]));
}
?>
