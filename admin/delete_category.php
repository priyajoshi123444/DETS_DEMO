<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the category ID is set in the URL
if (isset($_GET['id'])) {
    // Get the category ID from the URL
    $id = $_GET['id'];

    // Delete the category from the database
    $query = "DELETE FROM incomes_categories WHERE category_id=$id";
    $result = mysqli_query($conn, $query);

    // Check if the category was deleted successfully
    if ($result) {
        echo "Category deleted successfully.";
        header("Location:incomecategory.php");
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
} else {
    echo "Category ID not specified.";
}
?>