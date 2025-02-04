<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Item</h2>
        <form method="POST" action="../process/crud.php">
            <input type="text" name="name" placeholder="Item Name" required><br>
            <button type="submit" name="create">Add Item</button>
        </form>
        <br>
        <a href="read.php">View Items</a>
    </div>
</body>
</html>
