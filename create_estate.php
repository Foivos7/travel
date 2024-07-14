<?php
session_start();
require 'database-connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $rooms = $_POST['rooms'];
    $price_per_night = $_POST['price_per_night'];
    $user_id = $_SESSION['user_id'];

    if (preg_match("/^[a-zA-Z\s]+$/", $title) &&
        preg_match("/^[a-zA-Z\s]+$/", $location) &&
        is_numeric($rooms) && $rooms > 0 &&
        is_numeric($price_per_night) && $price_per_night > 0 &&
        isset($_FILES['photo'])) {

        $photo = "uploads/" . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo)) {
            $stmt = $pdo->prepare("INSERT INTO estates (photo, title, location, rooms, price_per_night, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$photo, $title, $location, $rooms, $price_per_night, $user_id])) {
                header("Location: feed.php");
                exit;
            } else {
                $error = "An error occurred while creating the estate.";
            }
        } else {
            $error = "Failed to upload the photo.";
        }
    } else {
        $error = "Invalid input.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create estate</title>
    <link rel="stylesheet" href="style.css">
<script type="text/javascript" src="validations.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h1>Create estate</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="create_estate.php" enctype="multipart/form-data">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" required>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <label for="rooms">Rooms:</label>
            <input type="number" id="rooms" name="rooms" required>
            <label for="price_per_night">Price per Night:</label>
            <input type="number" id="price_per_night" name="price_per_night" required><br>
            <button style="margin-top: 10px" type="submit">Create estate</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
