<?php
require("vendor/autoload.php");
use Razorpay\Api\Api;

$api_key = "rzp_test_qyoMPOYrHgXw3E";
$api_secret = "uGlJX4dct5JkKqPBaCfwaNX7";

$name = $_GET['name'] ?? 'Test User';
$email = $_GET['email'] ?? 'demo@example.com';

$api = new Api($api_key, $api_secret);

$orderData = [
    'receipt' => 'REG_' . time(),
    'amount' => 100,
    'currency' => 'INR',
    'payment_capture' => 1
];
$order = $api->order->create($orderData);
$order_id = $order['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Razorpay Payment</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav id="navbar">
  <a href="#home" class="nav-link active">Home</a>
  <a href="#speakers" class="nav-link">Speakers</a>
  <a href="#agenda" class="nav-link">Agenda</a>
  <a href="#venue" class="nav-link">Venue</a>
  <a href="#contact" class="nav-link">Contact</a>
  <a href="signup.php" class="signup-btn">Signup</a>
</nav>

<div class="pay-box">
  <h2>Pay ₹1 for Event Registration</h2>
  <button id="payBtn">Pay Now</button>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var options = {
      "key": "<?php echo $api_key; ?>",
      "amount": "100",
      "currency": "INR",
      "name": "Event",
      "description": "Event Registration ₹1",
      "order_id": "<?php echo $order_id; ?>",
      "handler": function (response){
          window.location.href = "success.php?payment_id=" + response.razorpay_payment_id;
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
