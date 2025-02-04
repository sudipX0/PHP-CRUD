<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <h2>Welcome, <?= $_SESSION['user']; ?></h2>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <h2>Welcome to the CRUD App</h2>
            <a href="auth/login.php">Login</a> | <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</body>
</html>
