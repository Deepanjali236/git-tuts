<?php
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->name) || !isset($data->email)) {
  echo json_encode(["success" => false, "message" => "Missing fields"]);
  exit;
}

$name = htmlspecialchars(trim($data->name));
$email = htmlspecialchars(trim($data->email));
require_once("db_connection.php");

$sql = "INSERT INTO registrations (name, email) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $email);
$stmt->execute();

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'your_email@gmail.com';
  $mail->Password = 'your_app_password'; // Use App Password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('your_email@gmail.com', 'Event Team');
  $mail->addAddress($email, $name);
  $mail->Subject = 'Event Registration';
  $mail->Body = "Hi $name,\n\nThanks for registering!\n\n- Event Team";

  $mail->send();
  echo json_encode(["success" => true, "message" => "Email sent"]);
} catch (Exception $e) {
  echo json_encode(["success" => false, "message" => "Email failed: {$mail->ErrorInfo}"]);
}

$stmt->close();
$conn->close();
?>
