<?php
session_start();
include 'db_connect.php';

// Set the header to indicate a JSON response
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Check if a post ID is provided in the POST request
$postData = json_decode(file_get_contents("php://input"), true);
if (!isset($postData['post_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No post ID specified']);
    exit;
}

$post_id = $postData['post_id'];

// Try deleting the post from the database
try {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
    $stmt->execute();

    // If no rows were affected, the post may not exist
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Post deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
    }
} catch (PDOException $e) {
    // Return error message if the deletion fails
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete post: ' . $e->getMessage()]);
}
?>

