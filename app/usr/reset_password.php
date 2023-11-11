<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ZipLink</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Reset Your Password</h1>
        </header>

        <main class="main-content">
            <form action="process_reset_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit" class="btn">Reset Password</button>
            </form>
        </main>
    </div>
</body>
</html>
