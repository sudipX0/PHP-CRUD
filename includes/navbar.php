<nav>
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="crud/read.php">Items</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="auth/login.php">Login</a></li>
                <li><a href="auth/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
