<?php
session_start();
require('razorpay_config.php');
require('db_connection.php');
require('vendor/autoload.php');

use Razorpay\Api\Api;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['razorpay_payment_id'];
    $order_id   = $_POST['razorpay_order_id'];
    $signature  = $_POST['razorpay_signature'];

    $api = new Api($keyId, $keySecret);

    try {
        // 🔐 Verify signature
        $attributes = [
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ];
        $api->utility->verifyPaymentSignature($attributes);

        // ✅ Update payment table
        $stmt = $conn->prepare("UPDATE payments SET status='Paid', payment_id=? WHERE order_id=?");
        $stmt->bind_param("ss", $payment_id, $order_id);
        $stmt->execute();

        // ✅ Insert into registrations table
        if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];
            $amount = $_SESSION['amount']; // set this when order created
            $status = "Paid";

            $stmt2 = $conn->prepare("INSERT INTO registrations (name, email, amount, payment_id, status) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("ssiss", $name, $email, $amount, $payment_id, $status);
            $stmt2->execute();
        }

        // 🔗 Redirect to success page
        header("Location: success.php?payment_id=" . $payment_id);
        exit;

    } catch (Exception $e) {
        // ❌ Redirect to failed page
        header("Location: failed.php?error=" . urlencode($e->getMessage()));
        exit;
    }
}
?>
