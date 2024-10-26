<?php
include 'db_connect.php'; // Include your database connection script
session_start(); // Start the session

// Define a hardcoded admin key (change this to a unique value for security)
define('ADMIN_KEY', '2707'); // Replace with your chosen key

// Initialize variables
$admin_key = '';
$admin_username = '';
$admin_password = '';
$admin_confirm_password = '';
$admin_error_message = '';
$admin_success_message = '';

// Process the registration form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_key = $_POST['admin_key'];
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];
    $admin_confirm_password = $_POST['confirm_password'];

    // Validate that the entered admin key matches the predefined key
    if ($admin_key !== ADMIN_KEY) {
        $admin_error_message = "Invalid Admin Key!";
    } elseif ($admin_password !== $admin_confirm_password) {
        // Validate that passwords match
        $admin_error_message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

        // Insert the new admin into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->execute([$admin_username, $hashed_password]);
            $admin_success_message = "Admin registered successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Duplicate entry error (e.g., username already exists)
                $admin_error_message = "Username already exists. Please choose another one.";
            } else {
                $admin_error_message = "An error occurred: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="tab">
            Admin Registration
        </div>
        
        <!-- Display error or success messages -->
        <?php if ($admin_error_message): ?>
            <p class="error-message"><?php echo $admin_error_message; ?></p>
        <?php endif; ?>
        <?php if ($admin_success_message): ?>
            <p class="success-message"><?php echo $admin_success_message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="admin_key" placeholder="Admin Key" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        
        <div class="contact-link">
            <a href="admin_login.php">Back to Admin Login</a>
        </div>
    </div>
    
    <span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span>
    
    <?php include 'templates/header.php'; ?>
</body>
</html>
