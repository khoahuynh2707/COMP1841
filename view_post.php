<?php
session_start();
include 'db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch the post based on post_id from URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    try {
        // Fetch the post
        $query = "SELECT * FROM posts WHERE id = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch replies to the post
        $reply_query = "SELECT replies.*, users.username FROM replies JOIN users ON replies.user_id = users.id WHERE replies.post_id = :post_id ORDER BY replies.created_at ASC";
        $reply_stmt = $pdo->prepare($reply_query);
        $reply_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $reply_stmt->execute();
        $replies = $reply_stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Post not found.";
    exit;
}

// Handle reply form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply_content = trim($_POST['reply_content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($reply_content)) {
        try {
            $query = "INSERT INTO replies (post_id, user_id, reply_content) VALUES (:post_id, :user_id, :reply_content)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':reply_content', $reply_content, PDO::PARAM_STR);
            $stmt->execute();

            // Reload the page to show the new reply
            header("Location: view_post.php?post_id=" . $post_id);
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Please enter a reply.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        <p>Posted on: <?php echo $post['created_at']; ?></p>

        <hr>

        <!-- Display replies -->
        <h2>Replies</h2>
        <?php if ($replies): ?>
            <?php foreach ($replies as $reply): ?>
                <div class="reply">
                    <p><strong><?php echo htmlspecialchars($reply['username']); ?>:</strong> <?php echo htmlspecialchars($reply['reply_content']); ?></p>
                    <p>Replied on: <?php echo $reply['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No replies yet. Be the first to reply!</p>
        <?php endif; ?>

        <hr>

        <!-- Reply form -->
        <h2>Reply to this post</h2>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <textarea name="reply_content" rows="4" cols="50" placeholder="Write your reply here..." required></textarea>
            <br>
            
                <button type="submit">Submit Reply</button>
            </div>
        </form>
        <div class="submit">
        <a href="index.php" class="back">Back to Home</a>
    </div>
    <?php include 'templates/headercontent.php'; ?> <!-- Include header content -->
</body>
</html>
