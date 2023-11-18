<?php
require_once '../db.php'; 

session_start(); // Start a new session or resume the existing one

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL to get user by email
    $sql = "SELECT UserID, Password FROM users WHERE Email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($userID, $hashedPassword);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashedPassword)) {
                    // Password is correct
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["UserID"] = $userID;

                    // Redirect user to portal page
                    header("Location: ../portal.php");
                    exit();
                } else {
                    // Password is not valid
                    displayErrorMessage("The password you entered was not valid.");
                }
            } else {
                // Email doesn't exist
                displayErrorMessage("No account found with that email.");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}

function displayErrorMessage($message) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Login Error - ZipLink</title>
        <link rel='stylesheet' href='../../assets/style.css'>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Login Error</h1>
            </header>

            <main class='main-content'>
                <p>$message</p>
                <a href='../login.php' class='btn'>Return to Login</a>
            </main>
        </div>
    </body>
    </html>";
}
?>
