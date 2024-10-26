<?php 
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}
include 'db_connect.php'; 

// Initialize variables
$title = '';
$content = '';
$image = '';
$success_message = '';
$error_message = '';

// Check if the uploads directory exists, if not, create it
if (!is_dir('uploads')) {
    mkdir('uploads', 0755, true);
}

// Process the form when it is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Validate image upload
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            $image = time() . '_' . $_FILES['image']['name'];
            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image)) {
                // Insert into the database if no errors occurred
                try {
                    // Modify the query to specify the columns explicitly
                    $stmt = $pdo->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
                    $stmt->execute([$title, $content, $image]);
                    $success_message = "Add posts succesfully!";
                    // Reset fields after successful submission
                    $title = '';
                    $content = '';
                    $image = '';
                } catch (PDOException $e) {
                    $error_message = "An error occurred: " . $e->getMessage();
                }
                
            } else {
                $error_message = "Image could not be saved. Please try again.";
            }
        } else {
            $error_message = "Only image formats allowed: JPG, JPEG, PNG, GIF.";
        }
    } else {
        $error_message = "Please select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Add Post</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- Path to CSS file if needed -->
</head>
<body>

<?php include 'templates/header.php'; ?> <!-- Include header -->

<h2>Add New Post</h2>

<?php
if ($success_message) {
    echo "<p style='color: green;'>$success_message</p>";
}
if ($error_message) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<form method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

    <label for="content">Content:</label><br>
    <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea><br><br>

    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image" accept="image/*" required><br><br>

    <input type="submit" value="Add Post">
</form>

<?php include 'templates/footer.php'; ?> <!-- Include footer -->

</body>
</html>
