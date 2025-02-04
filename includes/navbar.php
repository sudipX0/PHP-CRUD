<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="crud/list.php">Manage Items</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <!-- Only show logout link if the user is logged in -->
            <li><a href="auth/logout.php">Logout</a></li>
        <?php else: ?>
            <!-- Show login and register links if the user is not logged in -->
            <li><a href="auth/login.php">Login</a></li>
            <li><a href="auth/register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
