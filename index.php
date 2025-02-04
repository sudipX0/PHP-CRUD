<?php
session_start();
include 'header.php';
include 'navbar.php';
?>
<div class="container">
    <?php if (isset($_SESSION['user'])): ?>
        <h2>Welcome, <?= $_SESSION['user']; ?>!</h2>
        <p>You're logged in and ready to manage your items.</p>
        <a href="crud/create.php" class="button">Add New Item</a>
    <?php else: ?>
        <h2>Welcome to the CRUD App</h2>
        <p>Start by logging in or registering to manage your items.</p>
        <a href="auth/login.php" class="button">Login</a>
        <a href="auth/register.php" class="button">Register</a>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
