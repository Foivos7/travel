<?php
session_start();
require 'database-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (preg_match("/^[a-zA-Z]+$/", $first_name) &&
        preg_match("/^[a-zA-Z]+$/", $last_name) &&
        preg_match("/^[a-zA-Z0-9]+$/", $username) &&
        strlen($password) >= 4 && strlen($password) <= 10 && preg_match("/[0-9]/", $password) &&
        filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, password, email) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$first_name, $last_name, $username, $password_hash, $email])) {
            header("Location: login.php");
            exit;
        } else {
            $error = "An error occurred while creating your account";
        }
    } else {
        $error = "Invalid input";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
   <script type="text/javascript" src="validations.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="register.php">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <button style="margin-top: 10px" type="submit">Register</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
