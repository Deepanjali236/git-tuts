<?php
// === Step 1: Validate and sanitize ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Trim and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // === Step 2: Check if valid ===
    if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h3 style='color:red;'>Invalid input. Please go back and try again.</h3>";
        echo "<a href='index.html'>← Go Back</a>";
        exit;
    }

    // === Step 3: Save to CSV ===
    $file = 'registrations.csv';
    $data = [$name, $email, $message];
    $handle = fopen($file, 'a');
    fputcsv($handle, $data);
    fclose($handle);

    // === Step 4: Optional - Send confirmation email ===
    $subject = "Thanks for Registering!";
    $body = "Hi $name,\n\nThank you for registering for the Annual Tech Conference 2025.\n\nRegards,\nEvent Team";
    $headers = "From: noreply@event.com";

    // Suppress warning in localhost if mail fails
    @mail($email, $subject, $body, $headers);

    // === Step 5: Show confirmation ===
    echo "
    <div style='font-family:Arial; max-width:600px; margin:40px auto; text-align:center;'>
        <h2>✅ Registration Successful!</h2>
        <p>Thank you, <strong>$name</strong>, for registering.</p>
        <p>We've sent a confirmation email to <strong>$email</strong>.</p>
        <a href='index.html' style='color:#0066cc;'>← Go back to form</a>
    </div>";
} else {
    // If not a POST request
    header("Location: index.html");
    exit;
}
?>
