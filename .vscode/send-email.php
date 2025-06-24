<?php
header('Content-Type: application/json');

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit;
}

// Email configuration
$to = 'mrulwasihle@gmail.com';
$subject = 'New Contact Form Submission from ' . $name;
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Email body
$emailBody = "
<html>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> " . ($phone ? $phone : 'Not provided') . "</p>
    <p><strong>Message:</strong></p>
    <p>$message</p>
</body>
</html>
";

// Send email
$mailSent = mail($to, $subject, $emailBody, $headers);

if ($mailSent) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message']);
}
?>