<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ZipLink</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sign Up for ZipLink</h1>
        </header>

        <main class="main-content">
            <form action="process_signup.php" method="post">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <label for="company">Company (Optional):</label>
                <input type="text" id="company" name="company">

                <button type="submit" class="btn">Sign Up</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2023 ZipLink. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
