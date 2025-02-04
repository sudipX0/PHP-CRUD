<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']); // Check if user is logged in

// Handle Logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy session to log the user out
    header("Location: index.php"); // Redirect to home page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-gray-200 shadow-md w-full px-8 md:px-auto">
    <div class="md:h-16 h-28 mx-auto md:px-4 container flex items-center justify-between flex-wrap md:flex-nowrap">
        <!-- Logo -->
        <div class="text-indigo-500 md:order-1">
            <!-- You can replace this with your actual logo -->
            <span class="text-3xl font-semibold"><a href="index.php">MTM</a></span>
        </div>

        <!-- Navigation Links -->
        <div class="text-gray-500 order-3 w-full md:w-auto md:order-2">
            <ul class="flex font-semibold justify-between">
                <li class="md:px-4 md:py-2 text-indigo-500"><a href="index.php">Home</a></li>
                <li class="md:px-4 md:py-2 text-indigo-500"><a href="index.php">About</a></li>
                <li class="md:px-4 md:py-2 text-indigo-500"><a href="index.php">Contact Us</a></li>
            </ul>
        </div>

        <!-- User Authentication Links -->
        <div class="order-2 md:order-3 flex items-center space-x-4">
            <?php if ($is_logged_in): ?>
                <!-- Profile Button -->
                <a href="profile.php">
                    <button class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-gray-50 rounded-xl flex items-center gap-2">
                        <i class="fas fa-user-circle"></i>
                        Profile
                    </button>
                </a>

                <!-- Logout Button -->
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-gray-50 rounded-xl flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            <?php else: ?>
                <!-- Login Button -->
                <a href="login.html">
                    <button class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-gray-50 rounded-xl flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

</body>
</html>
