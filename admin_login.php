<?php
include 'db_connect.php'; // Include database connection script
session_start(); // Start the session

// Initialize variables for storing user input and error messages
$admin_username = '';
$admin_password = '';
$admin_error_message = '';

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['username'] ?? '';
    $admin_password = $_POST['password'] ?? '';

    // Fetch admin data from the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$admin_username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the admin exists and password matches
        if ($admin && password_verify($admin_password, $admin['password'])) {
            // Set session variables for successful login
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['loggedin'] = true; // Mark the user as logged in
            header('Location: admin_dashboard.php'); // Redirect to dashboard
            exit;
        } else {
            $admin_error_message = "Incorrect username or password.";
        }
    } catch (PDOException $e) {
        $admin_error_message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Inline styles for simplicity */
        body { font-family: 'Poppins', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f6f9; }
        .container { width: 100%; max-width: 400px; padding: 20px; background: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-control { width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { width: 100%; padding: 10px; background-color: #4CAF50; color: white; font-size: 18px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background-color: #45a049; }
        .error-message { color: red; margin-bottom: 15px; }
        .contact-link { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        
        <!-- Display error message if login fails -->
        <?php if ($admin_error_message): ?>
            <p class="error-message"><?php echo htmlspecialchars($admin_error_message); ?></p>
        <?php endif; ?>

        <form method="POST" action="admin_login.php">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        
        <!-- Links to registration and user login -->
        <div class="contact-link">
            <a href="admin_register.php">Register as Admin</a>
        </div>
            <h4>Or</h4>
        <div class="contact-link">
            <a href="login.php">Back to User Login</a>
        </div>
    </div>
    <?php include 'templates/header.php'; ?>
</body>
</html>

