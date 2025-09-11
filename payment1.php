<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->razorpay_payment_id)) {
    echo json_encode(["success" => false, "message" => "Invalid payment details."]);
    exit;
}

$id = $data->razorpay_payment_id;
$name = htmlspecialchars(trim($data->name));
$email = htmlspecialchars(trim($data->email));

// Load existing payments if file exists
$paymentsFile = "json/payments.json";
$payments = [];

if (file_exists($paymentsFile)) {
    $payments = json_decode(file_get_contents($paymentsFile), true);
    if (!is_array($payments)) {
        $payments = [];
    }
}

// Add new payment
$payments[] = [
    "id" => $id,
    "name" => $name,
    "email" => $email,
    "timestamp" => date("Y-m-d H:i:s")
];

// Save back to file
file_put_contents($paymentsFile, json_encode($payments, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "message" => "Payment recorded successfully."]);
?>
