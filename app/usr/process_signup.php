<?php
require_once '../db.php';

function displaySuccessMessage($message) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Signup Success - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Signup Success</h1>
            </header>

            <main class='main-content'>
                <p>$message</p>
                <a href='../../index.php' class='btn'>Return Home</a>
            </main>
        </div>
    </body>
    </html>";
}

function displayErrorMessage($message) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Signup Error - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Signup Error</h1>
            </header>

            <main class='main-content'>
                <p>$message</p>
                <a href='signup.php' class='btn'>Try Again</a>
            </main>
        </div>
    </body>
    </html>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullname']; // Assuming you have a fullname field in your form
    $email = $_POST['email'];
    $password = $_POST['password']; // Assuming plain text password from the form
    $company = isset($_POST['company']) ? $_POST['company'] : ''; // Optional company field

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a unique token for email verification
    $token = bin2hex(random_bytes(50)); 

    // SQL to insert new user into the users table
    $sql = "INSERT INTO users (FullName, Email, Password, Company, VerificationToken, IsActive) VALUES (?, ?, ?, ?, ?, FALSE)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $fullName, $email, $hashedPassword, $company, $token);

        if ($stmt->execute()) {
            // Send verification email
            $verifyLink = "https://ziplink.us/app/usr/verify.php?token=" . $token;
            $subject = "Verify Your Email for ZipLink";
            $message = "Please click on the following link to verify your account: " . $verifyLink;
            $headers = "From: noreply@ziplink.us";

            if (mail($email, $subject, $message, $headers)) {
                displaySuccessMessage("A link to verify your account has been sent to your email.");
            } else {
                displayErrorMessage("Failed to send verification email. Please check your email settings.");
            }
        } else {
            displayErrorMessage("Database error while inserting user: " . $stmt->error);
        }

        $stmt->close();
    } else {
        displayErrorMessage("Database error while preparing query: " . $conn->error);
    }
} else {
    displayErrorMessage("Invalid request method. Please use the signup form.");
}
?>
