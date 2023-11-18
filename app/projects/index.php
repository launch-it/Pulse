<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

require_once '../db.php'; 
$user_id = $_SESSION['user_id'];

// Add logic for handling form submissions (add/remove projects)

// Fetch projects from database
// $projects = ...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - ZipLink</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>My Projects</h1>
        
        <!-- Form for adding new projects -->
        <form method="post">
            <input type="text" name="title" placeholder="Project Title" required>
            <textarea name="description" placeholder="Project Description"></textarea>
            <button type="submit" name="addProject">Add Project</button>
        </form>

        <!-- Display projects -->
        <div class="projects-list">
            <?php
            // foreach ($projects as $project) {
            //     echo "<div class='project'>";
            //     echo "<h3>" . htmlspecialchars($project['title']) . "</h3>";
            //     echo "<p>" . htmlspecialchars($project['description']) . "</p>";
            //     // Add a delete button or link for each project
            //     echo "</div>";
            // }
            ?>
        </div>
    </div>
</body>
</html>
