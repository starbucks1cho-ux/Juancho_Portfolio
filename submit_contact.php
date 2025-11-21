<?php
// Database Credentials
$servername = "YOUR_RDS_ENDPOINT_HERE"; // Paste the RDS Endpoint from Step 1
$username = "admin";
$password = "YOUR_RDS_PASSWORD_HERE";
$dbname = "portfolio_db"; // You need to create this DB inside MySQL first

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist (Run this only once or do it via command line)
$sql = "CREATE DATABASE IF NOT EXISTS portfolio_db";
$conn->query($sql);
$conn->select_db($dbname);

// Create table if it doesn't exist
$table = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($table);

// Process the Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message Sent Successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>