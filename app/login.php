<?php
session_start();
require_once 'db.php'; // Adjust path as needed

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL to get user by email
    $sql = "SELECT UserID, Password FROM users WHERE Email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($userID, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Password is correct
                $_SESSION['user_id'] = $userID; // Set user_id in session

                header("Location: /app/portal.php"); // Redirect to portal
                exit();
            } else {
                // Password is not valid
                $errorMessage = 'Invalid password.';
            }
        } else {
            // Email not found
            $errorMessage = 'No account found with that email.';
        }
        $stmt->close();
    } else {
        $errorMessage = 'Database error. Please try again later.';
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZipLink</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="../assets/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="../assets/img/favicons/favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="../assets/img/favicons/favicon-180x180.png">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/favicon-270x270.png">
    <meta name="msapplication-TileColor" content="#007bff">
    <meta name="theme-color" content="#007bff">
</head>
<body>
    <div class="login-container">
        <header>
            <img src="../assets/img/logo.svg" alt="ZipLink">
            <h1>Login to ZipLink</h1>
        </header>
        <?php if ($errorMessage): ?>
            <div class="error">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <main class="main-content">
            <form action="login.php" method="post">
                <div class="login-email">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="login-passwd">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-unlock-alt"></i>
                </div>
                <button type="submit" class="btn">Login<i class="fas fa-sign-in-alt"></i></button>
            </form>
        </main>
    </div>
</body>
</html>