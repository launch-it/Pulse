<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZipLink</title>
    <link rel="stylesheet" href="../../assets/style.css"> <!-- Adjusted path to CSS file -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Login to ZipLink</h1>
        </header>

        <main class="main-content">
            <form action="usr/process_login.php" method="post"> <!-- Adjusted form action path -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn">Login</button>
            </form>
        </main>
    </div>
</body>
</html>
