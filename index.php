<?php
session_start();
include 'includes/navbar.php';
?>
<div class="container">
    <?php if (isset($_SESSION['user'])): ?>
        <h2>Welcome, <?= $_SESSION['user']; ?>!</h2>
        <p>You're logged in and ready to manage your items.</p>
        <a href="crud/create.php" class="button">Add New Item</a>
    <?php else: ?>
        <h2>Welcome to the CRUD App</h2>
        <p>Start by logging in or registering to manage your items.</p>
        <!-- These buttons will appear only when the user is not logged in -->
        <a href="auth/login.php" class="button">Login</a>
        <a href="auth/register.php" class="button">Register</a>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>

<!-- Link your CSS file directly here -->
<link rel="stylesheet" href="public/assets/css/style.css">
