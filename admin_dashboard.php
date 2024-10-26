<?php
// admin_dashboard.php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Rest of your dashboard code goes here
?>
<!DOCTYPE hmtl>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="header">
        <h2>Welcome to Admin Manage Dashboard!</h2>
        </div>
        <div class="navigation">
            <a href="manage_posts.php" class="btn">Manage Posts</a>
            <a href="manage_users.php" class="btn">Manage Users</a>
            <a href="manage_modules.php" class="btn">Manage Modules</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

    <?php include 'templates/Home.php'; ?>
</body></html>