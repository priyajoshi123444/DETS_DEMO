<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "Expense";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create user table
$sqlCreateUserTable = "
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender VARCHAR(10),
    mobile_number VARCHAR(15),
    profile_image VARCHAR(255),
    reset_token VARCHAR(255),
    reset_token_expiry DATETIME,
    reset_status BOOLEAN DEFAULT 0,
    last_password_change DATETIME
)";
// Execute the create table query
if ($conn->query($sqlCreateUserTable) == TRUE) {
    echo "User table created successfully\n";
} else {
    echo "Error creating user table: " . $conn->error . "\n";
}

// Close the connection
$conn->close();
?>
