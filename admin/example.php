<?php
// Include your database connection file
// include('db_connection.php'); // Replace with the actual filename

// Check if the user is logged in (you can modify this based on your authentication logic)
session_start();
if (!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    exit();
}

// Connect to the database (replace these variables with your actual database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id"; // Modify the query based on your database schema

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
} else {
    // Handle the case where user details are not found
    $userDetails = array(); // Empty array if user not found
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Add your CSS styles here -->
</head>
<body>

<!-- Sidebar with user details -->
<aside>
    <h2>User Profile</h2>
    <p>ID: <?php echo isset($userDetails['id']) ? $userDetails['id'] : ''; ?></p>
    <p>Username: <?php echo isset($userDetails['username']) ? $userDetails['username'] : ''; ?></p>
    <p>Email: <?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?></p>
    <!-- Add other user details as needed -->
</aside>

<!-- Main content of your page goes here -->
<main>
    <!-- Add your main content here -->
</main>

</body>
</html>
