<?php
$servername = "localhost"; // XAMPP's default server name
$username = "root";        // XAMPP default username
$password = "";            // XAMPP default password is empty
$dbname = "crudoperation"; // Your local DB name in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
