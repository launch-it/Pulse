<?php
require_once 'db.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $company = !empty($_POST['company']) ? $_POST['company'] : NULL;

    // Validate inputs: This is just a basic validation. Expand as needed.
    if ($password !== $confirmPassword) {
        die('Passwords do not match.');
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a verification token
    $verificationToken = bin2hex(random_bytes(50)); // Ensure this is secure

    // SQL to insert the new user
    $sql = "INSERT INTO users (FullName, Email, Company, Password, VerificationToken) VALUES (?, ?, ?, ?, ?)";

    // Prepare and bind parameters to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $fullName, $email, $company, $hashedPassword, $verificationToken);

        // Execute the query
        if ($stmt->execute()) {
      
            echo "Registration successful. Please check your email to verify your account.";
            if ($stmt->execute()) {
                // Compose verification email
                $verificationLink = "http://ziplink.us/app/usr/verify.php?token=" . $verificationToken;
                $subject = "Verify Your Email for ZipLink";
                $message = "Please click on the following link to verify your email: " . $verificationLink;
                $headers = "From: jared@ziplink.us";
            
                // Send verification email
                if(mail($email, $subject, $message, $headers)) {
                    // Redirect or inform the user
                    header("Location: registration_confirmation.php");
                    exit();
                } else {
                    echo "Error in sending verification email";
                }
            } else {
                // Handle error
                echo "Error: " . $stmt->error;
            }
            
        } else {
            // Handle error
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Handle error
        echo "Error: " . $conn->error;
    }
}
?>
