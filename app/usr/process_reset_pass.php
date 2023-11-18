<?php
require_once '../db.php';

function sendResetEmail($email, $token) {
    $resetLink = "http://ziplink.us/app/usr/new_password.php?token=" . $token;
    $subject = "Password Reset for ZipLink";
    $message = "Please click on the following link to reset your password: " . $resetLink;
    $headers = "From: noreply@ziplink.us";
    return mail($email, $subject, $message, $headers);
}

function displayMessage($message) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Password Reset Request - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Password Reset Request</h1>
            </header>
            <main class='main-content'>
                <p>$message</p>
                <a href='../../index.php' class='btn'>Return Home</a>
            </main>
        </div>
    </body>
    </html>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    $checkSql = "SELECT Email FROM users WHERE Email = ?";
    if ($checkStmt = $conn->prepare($checkSql)) {
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $token = bin2hex(random_bytes(50));
            $expires = new DateTime("now");
            $expires->add(new DateInterval('PT01H'));
            $expiresFormatted = $expires->format('Y-m-d H:i:s');

            $insertSql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
            if ($insertStmt = $conn->prepare($insertSql)) {
                $insertStmt->bind_param("sss", $email, $token, $expiresFormatted);
                if ($insertStmt->execute()) {
                    if (sendResetEmail($email, $token)) {
                        displayMessage("Please check your email to reset your password.");
                    } else {
                        displayMessage("Failed to send reset email. Please try again.");
                    }
                }
                $insertStmt->close();
            }
        } else {
            displayMessage("Account with this email could not be found.");
        }
        $checkStmt->close();
    }
} else {
    displayMessage("Invalid request. Please use the password reset form.");
}
?>
