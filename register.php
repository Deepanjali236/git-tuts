<?php
// Include database connection
include 'db_connection.php'; // Make sure to create this file for DB connection

// Set response type to JSON
header('Content-Type: application/json');

// Read JSON input sent via fetch
$input = file_get_contents("php://input");
$data = json_decode($input);

// Validate input
if (!$data || !isset($data->razorpay_payment_id) || !isset($data->name) || !isset($data->email)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input."
    ]);
    exit;
}

// Sanitize input
$name = htmlspecialchars(trim($data->name));
$email = htmlspecialchars(trim($data->email));
$razorpay_payment_id = htmlspecialchars(trim($data->razorpay_payment_id));

// Optional: Save payment details to the database
$sql = "INSERT INTO payments (name, email, payment_id) VALUES ('$name', '$email', '$razorpay_payment_id')";
if (mysqli_query($conn, $sql)) {
    // Send confirmation email (use mail() function or a library like PHPMailer)
    // mail($email, "Payment Successful", "Your payment was successful. Payment ID: $razorpay_payment_id");

    echo json_encode([
        "success" => true,
        "message" => "Payment successful! Thank you, $name."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);
}
?>
