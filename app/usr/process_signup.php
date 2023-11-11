<?php
require_once '../db.php'; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(50)); // Ensure this token is sufficiently random and secure

    // Set token expiration time, e.g., 1 hour from now
    $expires = new DateTime("now");
    $expires->add(new DateInterval('PT01H')); // 1 hour
    $expiresFormatted = $expires->format('Y-m-d H:i:s');

    // Insert or update the token in the database
    $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token=?, expires_at=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $email, $token, $expiresFormatted, $token, $expiresFormatted);

        if ($stmt->execute()) {
            // Send email
            $resetLink = "https://ziplink.us/app/usr/reset_password.php?token=" . $token;
            $subject = "Password Reset for ZipLink";
            $message = "Please click on the following link to reset your password: " . $resetLink;
            $headers = "From: noreply@ziplink.us";

            if (mail($email, $subject, $message, $headers)) {
                echo "Password reset link has been sent to your email.";
            } else {
                echo "Failed to send password reset email.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
?>
