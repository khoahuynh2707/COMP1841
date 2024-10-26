<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <title>Manage Posts</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <style>
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }
        h1 {
            color: #4a4a4a;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }
        .btn {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            margin: 5px;
        }
        .add-post-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #4a4a4a;
            background: linear-gradient(to right, #c6ffdd, #fbd786, #f7797d);
            border-radius: 30px;
            text-decoration: none;
            text-align: center;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-right: 10px;
        }
        .add-post-btn:hover {
            background: linear-gradient(to right, #c6ffdd, #fbd786, #f7797d);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #e8f5e9;
            color: #4caf50;
        }
        .error {
            background-color: #ffebee;
            color: #f44336;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Posts</h1>
            <a href="list_posts.php" class=" add-post-btn">Add New Post</a>
    
        <br>
        <a href="admin_dashboard.php" class="btn">Back to Admin Dashboard</a>
    </div>

    <?php include 'templates/headercontent.php'; ?>
</body>
</html>