<?php
session_start();
require 'database-connection.php';

$stmt = $pdo->prepare("SELECT * FROM estates");
$stmt->execute();
$estates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h1>Available Real Estates</h1>
        <div class="estates">
            <?php foreach ($estates as $estate): ?>
                <div class="estate">
                    <img src="<?php echo $estate['photo']; ?>" width="400" height="300" alt="Photo">
                    <h2><?php echo $estate['title']; ?></h2>
                    <p>Location: <?php echo $estate['location']; ?></p>
                    <p>Rooms: <?php echo $estate['rooms']; ?></p>
                    <p>Price per Night: $<?php echo $estate['price_per_night']; ?></p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="book.php?estate_id=<?php echo $estate['id']; ?>" class="btn">Book</a>
                    <?php else: ?>
                        <p>Please <a href="login.php">login</a> to book</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
