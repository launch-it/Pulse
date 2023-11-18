<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../db.php'; // Adjust path as needed
$errorMessage = '';

// Function to generate a random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $destination = $_POST['destination'];
    $user_id = $_SESSION['user_id']; // Get user ID from session

    // Generate a random URL string
    $randomURL = generateRandomString();
    $fullURL = "http://ziplink.us/t/" . $randomURL;

    // Insert project and random URL into database
    $stmt = $conn->prepare("INSERT INTO projects (title, description, destination, random_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $destination, $fullURL);
    if ($stmt->execute()) {
        // ... rest of your code
    } else {
        $errorMessage = 'Error adding project: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project - ZipLink</title>
    <link rel="stylesheet" href="../../assets/style.css"> <!-- Adjust path as needed -->
</head>
<body>
    <div class="container">
        <h1>Add New Project</h1>

        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form action="add_project.php" method="post">
            <label for="title">Project Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>

            <button type="submit" class="btn">Add Project</button>
        </form>
    </div>
</body>
</html>
