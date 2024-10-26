<?php
session_start();
include 'db_connect.php'; // Include database connection if needed

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to the Home Page</h1>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p>Hello, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>! Glad to meet  you .</p>";
            }
            ?>
        </div>

        <!-- Navigation Links -->
        <div class="navigation">
            <a href="index.php" class="btn">Dashboard</a>
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="mailto:huynhanhkhoa2707@gmail.com" class="btn">Contact Admin</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <!-- Main Content -->

        </div>
    </div>
    <?php include 'templates/HOME.php'; ?>
</body>
</html>
