<?php
$host = "localhost"; // Change if your database is hosted elsewhere
$username = "sudeep";
$password = "Hello@502."; // Add your database password if set
$database = "fedora";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment for debugging
// echo "Connected successfully";
?>
