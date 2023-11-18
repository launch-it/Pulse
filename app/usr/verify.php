<?php
require_once '../db.php'; 

function displayMessage($message, $success = true) {
    $buttonText = $success ? 'Go to Login' : 'Try Again';
    $buttonLink = $success ? '../login.php' : 'signup.php';

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Account Verification - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Account Verification</h1>
            </header>

            <main class='main-content'>
                <p>$message</p>
                <a href='$buttonLink' class='btn'>$buttonText</a>
            </main>
        </div>
    </body>
    </html>";
}

// Check if the token is in the query string
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // SQL to check if the token exists and if the account is not already active
    $sql = "SELECT UserID FROM users WHERE VerificationToken = ? AND IsActive = FALSE";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $token);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $updateSql = "UPDATE users SET IsActive = TRUE, VerificationToken = NULL WHERE VerificationToken = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("s", $token);
                    if ($updateStmt->execute()) {
                        displayMessage("Your account has been activated successfully.");
                    } else {
                        displayMessage("Error: " . $updateStmt->error, false);
                    }
                    $updateStmt->close();
                } else {
                    displayMessage("Error: " . $conn->error, false);
                }
            } else {
                displayMessage("Invalid or expired verification link.", false);
            }
        } else {
            displayMessage("Error: " . $stmt->error, false);
        }

        $stmt->close();
    } else {
        displayMessage("Error: " . $conn->error, false);
    }
} else {
    displayMessage("No verification token provided.", false);
}
?>
