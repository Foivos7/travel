<?php
session_start();
require 'database-connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['estate_id'])) {
    $estate_id = $_GET['estate_id'];
    $stmt = $pdo->prepare("SELECT * FROM estates WHERE id = ?");
    $stmt->execute([$estate_id]);
    $estate = $stmt->fetch();

    if (!$estate) {
        header("Location: feed.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE estate_id = ? AND ((start_date BETWEEN ? AND ?) OR (end_date BETWEEN ? AND ?))");
    $stmt->execute([$estate_id, $start_date, $end_date, $start_date, $end_date]);
    $existing_reservations = $stmt->fetchAll();

    if ($existing_reservations) {
        $error = "The estate is not available for the selected dates.";
    } else {
        $user_id = $_SESSION['user_id'];
        $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
        $initial_price = $estate['price_per_night'] * $days;
        $discount = rand(10, 30) / 100;
        $total_price = $initial_price - ($initial_price * $discount);

        $stmt = $pdo->prepare("INSERT INTO reservations (estate_id, user_id, start_date, end_date, total_price) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$estate_id, $user_id, $start_date, $end_date, $total_price])) {
            header("Location: feed.php");
            exit;
        } else {
            $error = "An error occurred while booking.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
    <link rel="stylesheet" href="style.css">
<script type="text/javascript" src="validations.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h1>Book estate</h1>
        <div class="estate-details">
            <img src="<?php echo $estate['photo']; ?>" width="500" height="400" alt="Photo">
            <h2><?php echo $estate['title']; ?></h2>
            <p>Location: <?php echo $estate['location']; ?></p>
            <p>Rooms: <?php echo $estate['rooms']; ?></p>
            <p>Price per Night: $<?php echo $estate['price_per_night']; ?></p>
        </div>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="book.php?estate_id=<?php echo $estate_id; ?>">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            <button type="submit">Check Availability</button>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($error)): ?>
            <div class="booking-summary">
                <p>Initial Price: $<?php echo $initial_price; ?></p>
                <p>Discount: <?php echo ($discount * 100); ?>%</p>
                <p>Total Price: $<?php echo $total_price; ?></p>
                <form method="post" action="confirm_booking.php?estate_id=<?php echo $estate_id; ?>">
                    <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
                    <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                    <button type="submit">Confirm Booking</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
