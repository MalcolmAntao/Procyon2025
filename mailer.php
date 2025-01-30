<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete all fields correctly.";
        exit;
    }

    // Update recipient email
    $recipient = "your-email@example.com"; // Change to your actual email
    $subject = "New Contact from $name";
    $email_content = "Name: $name\nEmail: $email\nMessage:\n$message\n";
    $email_headers = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Error: Could not send your message.";
    }
} else {
    http_response_code(403);
    echo "Invalid request.";
}
?>