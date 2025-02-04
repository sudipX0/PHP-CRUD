<?php
session_start();
require '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: read.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Item</h2>
        <form method="POST" action="../process/crud.php">
            <input type="hidden" name="id" value="<?= $item['id']; ?>">
            <input type="text" name="name" value="<?= $item['name']; ?>" required><br>
            <button type="submit" name="update">Update Item</button>
        </form>
        <br>
        <a href="read.php">Back to List</a>
    </div>
</body>
</html>
