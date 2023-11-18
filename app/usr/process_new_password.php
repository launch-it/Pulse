<?php
require_once '../db.php';

function displayMessage($message, $linkText = 'Return Home', $linkHref = '../../../index.php') {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Password Reset Status - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Password Reset Status</h1>
            </header>
            <main class='main-content'>
                <p>$message</p>
                <a href='$linkHref' class='btn'>$linkText</a>
            </main>
        </div>
    </body>
    </html>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Verify if the token exists and is valid
        $sql = "SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE users SET Password = ? WHERE Email = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("ss", $hashedPassword, $user['email']);
                    $updateStmt->execute();

                    // Consider deleting the token from password_resets table
                    // ...

                    displayMessage("Password has been reset successfully.", "Login here", "login.php");
                }
            } else {
                displayMessage("Invalid or expired token.");
            }
            $stmt->close();
        }
    } else {
        displayMessage("Passwords do not match.");
    }
} else {
    displayMessage("Invalid request.");
}
?>
