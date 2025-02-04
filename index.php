<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | My Website</title>
</head>
<body>

    <!-- Main Content -->
    <div>
        <h1>Welcome to My Website</h1>
        <p>This is a simple homepage with a navbar linking to the profile section.</p>
        <?php if ($is_logged_in): ?>
            <p>You are logged in! Click on "Profile" to view or edit your details.</p>
        <?php else: ?>
            <p>Please log in or sign up to access your profile.</p>
        <?php endif; ?>
    </div>

</body>
</html>
