<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="feed.php">Real Estates List</a></li>
        <li><a href="create_estate.php">Create Estate</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>