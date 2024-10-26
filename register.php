<?php 
include 'db_connect.php'; 

// Initialize variables
$username = '';
$email = '';
$password = '';
$success_message = '';
$error_message = '';

// Process the registration form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);
        $success_message = "Registration successful!";
        // Reset fields after successful submission
        $username = '';
        $email = '';
        $password = '';
    } catch (PDOException $e) {
        $error_message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Inline styles for simplicity */
        .container { width: 100%; max-width: 400px; padding: 20px; margin: auto; text-align: center; }
        .form-group { display: flex; align-items: center; margin-bottom: 15px; }
        .form-control { flex: 1; padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 5px; margin-left: 10px; }
        .icon { font-size: 50px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Vinwo</h1>
    <h2>BY Anh Khoa</h2>
    <div class="tab-container">
        Register
    </div>
    
    <div id="register-form" style="display: block;">
        <form action="register.php" method="POST">
            <?php if (!empty($success_message)) : ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <i class="fas fa-user"></i> <!-- Full Name Icon -->
                <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-user"></i> <!-- Username Icon -->
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-envelope"></i> <!-- Email Icon -->
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock"></i> <!-- Password Icon -->
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
    
    <div class="link-container">
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
    <div class="admin-link">
        <p>Are you an admin? <a href="admin_login.php">Admin Login Here</a></p>
    </div>
    <div class="contact-link">
        <a href="mailto:huynhanhkhoa2707@gmail.com">Contact Admin</a>
    </div>

<?php include 'templates/header.php'; ?>
</body>
</html>
