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

if (!$item) {
    header("Location: read.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Are you sure you want to delete "<?= $item['name']; ?>"?</h2>
        <form method="GET" action="../process/crud.php">
            <input type="hidden" name="delete" value="<?= $item['id']; ?>">
            <button type="submit">Yes, Delete</button>
        </form>
        <br>
        <a href="read.php">Cancel</a>
    </div>
</body>
</html>
