<?php
// Ensure session is started
session_start();

// Check if user_id is provided and if the request method is POST
if(isset($_POST['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtain user_id from the form submission
    $user_id = $_POST['user_id'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "expense_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE user_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Handle preparation error
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        // User deleted successfully
        echo "User deleted successfully";
        header('Location: user.php');
    } else {
        // Error occurred while deleting user
        echo "Error deleting user: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle case where user_id is not provided or request method is not POST
    echo "Invalid request";
}
?>
