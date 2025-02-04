<?php
session_start();
require '../config/database.php';

$stmt = $pdo->query("SELECT * FROM items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Item List</h2>
        <a href="create.php">Add New Item</a><br><br>
        <ul>
            <?php foreach ($items as $item): ?>
                <li>
                    <?= $item['name']; ?>
                    <a href="update.php?id=<?= $item['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $item['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <br>
        <a href="../index.php">Back to Home</a>
    </div>
</body>
</html>
