<?php
// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $expenseId = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "expense_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

// Check if budget ID is provided
if (!isset($_GET['id'])) {
    echo "Budget ID not provided";
    exit();
}

$budget_id = $_GET['id'];

// Delete budget record from the database
$sql = "DELETE FROM budget WHERE budget_id = $budget_id";

if ($conn->query($sql) === TRUE) {
    // Redirect back to the view budget page after deletion
    header("Location: viewbudget.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

// Close database connection

?>
