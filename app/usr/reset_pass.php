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
            <form action="process_reset_pass.php" method="post" class="reset-form">
                <div class="form-group">
                    <label for="email">Enter your email address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="btn">Reset Password</button>
            </form>
        </main>
    </div>
</body>
</html>
