<?php
require_once '../db.php'; // Adjust path as needed

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
                    // Password is correct, start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["UserID"] = $userID;

                    // Redirect user to portal page
                    header("Location: ../portal.php");
                    exit();
                } else {
                    // Password is not valid
                    echo "The password you entered was not valid.";
                }
            } else {
                // Email doesn't exist
                echo "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>
