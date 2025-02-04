<?php
require '../config/database.php';

// Create Item
if (isset($_POST['create'])) {
    $name = trim($_POST['name']);
    $stmt = $pdo->prepare("INSERT INTO items (name) VALUES (?)");
    if ($stmt->execute([$name])) {
        header("Location: ../crud/read.php?message=Item added successfully.");
    }
}

// Update Item
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $pdo->prepare("UPDATE items SET name = ? WHERE id = ?");
    if ($stmt->execute([$name, $id])) {
        header("Location: ../crud/read.php?message=Item updated successfully.");
    }
}

// Delete Item
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: ../crud/read.php?message=Item deleted successfully.");
    }
}
?>
