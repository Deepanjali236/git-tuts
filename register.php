<?php
// Set response type to JSON
header('Content-Type: application/json');

// Read JSON input sent via fetch
$input = file_get_contents("php://input");

// Try decoding JSON
$data = json_decode($input);

// Validate JSON structure
if (!$data || !isset($data->name) || !isset($data->email)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input. Please provide both name and email."
    ]);
    exit;
}

// Sanitize input
$name = htmlspecialchars(trim($data->name));
$email = htmlspecialchars(trim($data->email));

// Optional: Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format."
    ]);
    exit;
}

// Optional: Save to a file (e.g., data.txt)
$file = fopen("data.txt", "a"); // Open file in append mode
fwrite($file, "Name: $name, Email: $email\n");
fclose($file);

// Respond to frontend
echo json_encode([
    "success" => true,
    "message" => "Hi $name! Your email ($email) was received successfully."
]);
?>
