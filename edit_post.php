<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if post ID is provided
if (!isset($_GET['post_id'])) {
    echo "No post ID specified.";
    exit;
}

$postId = $_GET['post_id'];
$successMessage = ""; // Variable to store success message

// Fetch the post data
try {
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if post exists
    if (!$post) {
        echo "Post not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching post: " . $e->getMessage();
    exit;
}

// Handle form submission for updating the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['title'];
    $newContent = $_POST['content'];

    // Update the post in the database
    try {
        $updateQuery = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':title', $newTitle, PDO::PARAM_STR);
        $stmt->bindParam(':content', $newContent, PDO::PARAM_STR);
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        // Set success message
        $successMessage = "Post updated successfully!";
    } catch (PDOException $e) {
        echo "Error updating post: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <div class="container">
        <h1>Edit Post</h1>  

        <!-- Display success message -->
        <?php if ($successMessage): ?>
            <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">New Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
            
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
            <div class="submit">
                <button type="submit" fdprocessedid="qjtkrq">Update Post</button>
            </div>
        </form>

        <a href="index.php" class="back">Back to Home</a>
    </div>
    <?php include 'templates/headercontent.php'; ?>
</body>
</html>
