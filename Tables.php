<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Expense";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create a user table
$sql = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_picture_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    name VARCHAR(255) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    confirmpassword VARCHAR(255) NOT NULL
);
";



// Execute the query
if ($conn->query($sql) == TRUE) {
    echo "User table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>