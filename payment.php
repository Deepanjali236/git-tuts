<?php
require_once("vendor/autoload.php");
use Razorpay\Api\Api;

$api_key = "rzp_test_qyoMPOYrHgXw3E";
$api_secret = "uGlJX4dct5JkKqPBaCfwaNX7";

$api = new Api($api_key, $api_secret);

// Step 1: Create order
$orderData = [
    'receipt'         => 'ORD_' . time(),
    'amount'          => 100, 
    'currency'        => 'INR',
    'payment_capture' => 1
];
$order = $api->order->create($orderData);
$order_id = $order['id'];

// Step 2: Prepare checkout data
$data = [
    "key"        => $api_key,
    "amount"     => $orderData['amount'],
    "currency"   => $orderData['currency'],
    "name"       => "Acme Corp",
    "description"=> "Test transaction",
    "image"      => "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
    "prefill"    => [
        "name"    => "Test User",
        "email"   => "test@example.com",
        "contact" => "9999999999",
    ],
    "notes"      => [
        "address" => "Razorpay Corporate Office",
        "merchant_order_id" => "12312321",
    ],
    "theme"      => [
        "color" => "#3399cc"
    ],
    "order_id"   => $order_id,
];

$json = json_encode($data);

// Step 3: Load Razorpay checkout template
$checkout = "automatic"; // or "manual"
require("checkout/{$checkout}.php");
