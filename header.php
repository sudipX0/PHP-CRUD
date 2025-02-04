<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']); // Check if user is logged in
?>

<nav>
    <div>My Website</div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if ($is_logged_in): ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.html">Login</a></li>
            <li><a href="signup.html">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>
