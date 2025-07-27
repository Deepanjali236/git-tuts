<?php
header('Content-Type: application/json');

// 1️⃣ Load Composer packages (like PHPMailer)
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 2️⃣ Debug input (optional, can remove later)
$input = file_get_contents("php://input");
file_put_contents("debug_log.txt", $input); // DEBUG
$data = json_decode($input);

// 3️⃣ Check required fields
if (!$data || !isset($data->name) || !isset($data->email) || !isset($data->message)) {
  echo json_encode([
    "success" => false,
    "message" => "Missing fields",
    "received" => $input
  ]);
  exit;
}

// 4️⃣ Sanitize input
$name = htmlspecialchars(trim($data->name));
$email = htmlspecialchars(trim($data->email));
$message = htmlspecialchars(trim($data->message));

// 5️⃣ Database insert
require_once("db_connection.php");

$sql = "INSERT INTO registrations (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

if (!$stmt->execute()) {
  echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
  exit;
}

// 6️⃣ Email sending
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'anjalikarthi02@gmail.com'; // your Gmail
  $mail->Password = 'wlth mdlg ztqt ypcy'; // 🔐 use app password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('anjalikarthi02@gmail.com', 'Event Team');
  $mail->addAddress($email, $name);

  $mail->isHTML(false);
  $mail->Subject = 'Event Registration Confirmation';
  $mail->Body = "Hi $name,\n\nThank you for registering!\n\nBest regards,\nEvent Team";

  $mail->send();

  echo json_encode(["success" => true, "message" => "Registered successfully! Confirmation email sent."]);

} catch (Exception $e) {
  echo json_encode(["success" => true, "message" => "Registered, but email failed: {$mail->ErrorInfo}"]);
}

// ✅ Close DB
$stmt->close();
$conn->close();
?>
