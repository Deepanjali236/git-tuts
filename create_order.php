<?php
require_once("vendor/autoload.php");
use Razorpay\Api\Api;

$api_key = "rzp_test_qyoMPOYrHgXw3E";
$api_secret = "uGlJX4dct5JkKqPBaCfwaNX7"; // Replace with actual test secret

$name = $_GET['name'] ?? 'Test User';
$email = $_GET['email'] ?? 'demo@example.com';

$api = new Api($api_key, $api_secret);

$orderData = [
  'receipt' => 'REG_' . time(),
  'amount' => 100, // ₹1 in paise
  'currency' => 'INR',
  'payment_capture' => 1
];

$order = $api->order->create($orderData);
$order_id = $order['id'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Razorpay Payment</title>
</head>
<body>
  <h2>Complete Your ₹1 Payment</h2>
  <button id="payBtn">Pay Now</button>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    var options = {
      "key": "<?php echo $api_key; ?>",
      "amount": "100",
      "currency": "INR",
      "name": " Event",
      "description": "Event Registration",
      "order_id": "<?php echo $order_id; ?>",
      "handler": function (response){
          alert("Payment Success!\nPayment ID: " + response.razorpay_payment_id);
      },
      "prefill": {
          "name": "<?php echo $name; ?>",
          "email": "<?php echo $email; ?>",
          "contact": "9999999999"
      },
      "theme": {
          "color": "#3399cc"
      }
    };

    var rzp = new Razorpay(options);
    document.getElementById('payBtn').onclick = function(e){
      rzp.open();
      e.preventDefault();
    };
  </script>
</body>
</html>
