<?php
require_once 'db.php'; // Include your database connection file

// Check if the token is in the query string
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // SQL to check if the token exists and if the account is not already active
    $sql = "SELECT UserID FROM users WHERE VerificationToken = ? AND IsActive = FALSE";

    // Prepare and bind parameters to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $token);

        // Execute the query
        if ($stmt->execute()) {
            // Store the result so we can check if the account exists
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Token is valid and account is not activated yet
                // SQL to activate the account
                $updateSql = "UPDATE users SET IsActive = TRUE, VerificationToken = NULL WHERE VerificationToken = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("s", $token);
                    if ($updateStmt->execute()) {
                        echo "Your account has been activated successfully.";
                    } else {
                        echo "Error: " . $updateStmt->error;
                    }
                    $updateStmt->close();
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Invalid or expired verification link.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No verification token provided.";
}
?>
