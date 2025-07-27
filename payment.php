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

file_put_contents("json/payments.json", json_encode([
  "id" => $id,
  "name" => $name,
  "email" => $email,
  "timestamp" => date("Y-m-d H:i:s")
], JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "message" => "Payment recorded successfully."]);
?>
