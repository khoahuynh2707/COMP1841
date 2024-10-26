<?php
session_start();
include 'db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Initialize the module variable
$module = $_GET['module'] ?? null; // Use null if 'module' is not set

// Initialize filters
$category = isset($_GET['category']) && $_GET['category'] !== 'all' ? $_GET['category'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

// Add filters to query
$query = "SELECT * FROM posts WHERE 1=1";
$filters = [];

if ($category) {
    $query .= " AND category = :category";
    $filters[':category'] = $category;
}

if ($date) {
    $query .= " AND DATE(created_at) = :date";
    $filters[':date'] = $date;
}

if ($keyword) {
    $query .= " AND (title LIKE :keyword OR content LIKE :keyword)";
    $filters[':keyword'] = '%' . $keyword . '%';
}

$query .= " ORDER BY created_at DESC"; // Append ordering

// Prepare and execute query
try {
    $stmt = $pdo->prepare($query);

    // Bind each filter parameter if it exists
    foreach ($filters as $param => $value) {
        $stmt->bindValue($param, $value);
    }

    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error fetching posts: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        function toggleFilterForm() {
            const filterForm = document.getElementById('filterForm');
            filterForm.style.display = filterForm.style.display === 'block' ? 'none' : 'block';
        }

        // AJAX function for deleting a post
        function deletePost(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                fetch('delete_post.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById(`post-${postId}`).remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the post.');
                });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Welcome to Dashboard, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>!";
                } else {
                    echo "You are not logged in.";
                }
                ?>
            </h1>
        </div>

        <!-- Action buttons -->
        <div class="action-buttons">
            <a href="Home.php" class="btn">Home</a>
            <a href="list_posts.php" class="btn">Create New Post</a>
            <a href="mailto:huynhanhkhoa2707@gmail.com" class="btn">Contact Admin</a>
        </div>

        <!-- Filter Button and Form -->
        <div class="flex--item">
            <button class="s-btn s-btn__outlined s-btn__sm s-btn__icon ws-nowrap btn" onclick="toggleFilterForm()" role="button" aria-expanded="false">
                <svg aria-hidden="true" class="svg-icon iconFilter" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M2 4h14v2H2zm2 4h10v2H4zm8 4H6v2h6z"></path>
                </svg>
                Filter
            </button>
        </div>

        <!-- Filter Form (Initially Hidden) -->
        <div id="filterForm" class="filter-form" style="display:none;">
            <h3>Filter Options</h3>
            <form action="index.php" method="GET">
                <div class="filter-option">
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="all">All</option>
                        <option value="category1">Nearest</option>
                        <option value="category2">Recent activity</option>
                        <option value="category3">Most Frequent</option>
                    </select>
                </div>
                <div class="filter-option">
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date">
                </div>
                <div class="filter-option">
                    <label for="keyword">Keyword:</label>
                    <input type="text" name="keyword" id="keyword" placeholder="Enter keyword...">
                </div>
                <input type="submit" class="btn" value="Apply Filters">
            </form>
        </div>

        <!-- Display posts -->
        <h2>All Posts</h2>
        <div class="posts">
            <?php
            if (isset($error_message)) {
                echo "<p style='color: red;'>" . htmlspecialchars($error_message) . "</p>";
            } elseif ($posts) {
                foreach ($posts as $post) {
                    echo "<div id='post-" . $post['id'] . "' class='post'>";
                    echo "<h2>Poster: <a href='view_post.php?post_id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a></h2>";
                    echo "<p>Post Content: " . htmlspecialchars($post['content']) . "</p>";
                    
                    // Display the module if it exists
                    if (isset($post['module'])) {
                        echo "<p>Module: " . htmlspecialchars($post['module']) . "</p>";
                    }

                    // Display the created_at timestamp
                    $createdAt = new DateTime($post['created_at']);
                    echo "<div class='post-meta'>Posted on: " . $createdAt->format('F j, Y, g:i a') . "</div>";

                    // Edit and Delete buttons
                    echo "<a href='edit_post.php?post_id=" . $post['id'] . "' class='btn'>Edit</a>";
                    echo "<button class='btn-delete' onclick='deletePost(" . $post['id'] . ")'>Delete</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No posts found.</p>";
            }
            ?>
        </div>
        <?php include 'templates/headercontent.php'; ?>
    </div>
</body>
</html>

    </div>
</body>
</html>


