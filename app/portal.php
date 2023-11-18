<?php
session_start();
if (!isset($_SESSION['user_id'])) { // Assuming 'user_id' is set upon successful login
    header('Location: login.php'); // Redirect to login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - ZipLink</title>
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
    <div id="navbar" class="sidebar">
        <div class="logo">
            <img src="../assets/img/logo_alt.svg" alt="ZipLink">
            <h2>ZipLink Portal</h2>
        </div>
        <ul>
            <li><a href="/app/projects/"><i class="fas fa-folder-open"></i><span>Projects</span></a></li>
            <li><a href="/logout.php"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a></li>
            <li><a href="#" id="collapseToggle"><i class="fas fa-angle-double-right"></i><span>Collapse Menu</span></a></li>
        </ul>
    </div>
    <div class="portal-content">
        <h1>Welcome to Your Portal</h1>
        <p>Session ID: <?php echo session_id(); ?></p> <!-- Displaying the session ID -->
        <p>Manage your projects and settings here.</p>
        <!-- Additional portal content goes here -->
    </div>
<script src="../assets/js/global.js"></script>
</body>
</html>