<?php include 'templates/header.php'; ?>
<?php include 'db_connect.php'; ?>

<?php
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query = "INSERT INTO users (username, email) VALUES (:username, :email)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username, 'email' => $email]);

    echo "New user added!";
}
?>
<h2>Add New User</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required />
    <input type="email" name="email" placeholder="Email" required />
    <button type="submit" name="add_user">Add User</button>
</form>

<?php include 'templates/footer.php'; ?>
