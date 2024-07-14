<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Estate</title>
    <link rel="stylesheet" href="style.css">
<script type="text/javascript" src="validations.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h1>Welcome to DS Estate</h1>
        <p>Find the best places for short-term rental.</p>
        <a href="feed.php" class="btn">View estates</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>