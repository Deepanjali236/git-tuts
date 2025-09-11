<?php
require 'vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get payment ID from Razorpay
$paymentId = htmlspecialchars($_GET['payment_id'] ?? 'N/A');

// Dummy user info (replace with real values if stored via session or payment)
$name = $_SESSION['username'] ?? 'User';
$email = $_SESSION['email'] ?? 'demo@example.com';

// SEND EMAIL
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'anjalikarhi.02@gmail.com';       // Your Gmail
    $mail->Password   = 'ntaz qsec mmjq mfzm';          //  Use Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('anjalikarthi.02@gmail.com', 'Event Team');
    $mail->addAddress($email, $name);

    $mail->Subject = 'Payment Successful - Event Registration';
    $mail->Body    = "Hi $name,\n\nThank you for registering and successfully paying ₹1 for the Deepanjali Event.\n\n🧾 Payment ID: $paymentId\n\nWe're excited to see you at the event!\n\n- Deepanjali Team";

    $mail->send();
    $emailStatus = "Confirmation email sent.";
} catch (Exception $e) {
    $emailStatus = "Email could not be sent. Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Confirmation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f9f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .confirmation-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 128, 0, 0.1);
      text-align: center;
    }

    .confirmation-box h2 {
      color: green;
    }

    .payment-id {
      font-weight: bold;
      margin-top: 10px;
    }

    .btn-home {
      margin-top: 20px;
      background: #04AA6D;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }

    .btn-home:hover {
      background: #038e5c;
    }
  </style>
</head>
<body>
  <div class="confirmation-box">
    <h2> Payment Successful!</h2>
    <p>Thank you for your registration, <strong><?php echo $name; ?></strong>.</p>
    <p class="payment-id">🧾 Payment ID: <code><?php echo $paymentId; ?></code></p>
    <p><?php echo $emailStatus; ?></p>
    <a href="index.php" class="btn-home">Back to Home</a>
  </div>
</body>
</html>
