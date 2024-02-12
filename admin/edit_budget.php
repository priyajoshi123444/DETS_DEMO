<?php
// Start session
session_start();

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if budget ID is provided
if (!isset($_GET['id'])) {
    echo "Budget ID not provided";
    exit();
}

$budget_id = $_GET['id'];

// Retrieve budget data from the database
$sql = "SELECT * FROM budget WHERE budget_id = $budget_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $budget = $result->fetch_assoc();
} else {
    echo "Budget not found";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update budget record in the database
    $name = $_POST['name'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $description = $_POST['description'];

    $sql = "UPDATE budget SET name='$name', category='$category', amount='$amount', startdate='$startdate', enddate='$enddate', description='$description' WHERE budget_id=$budget_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to budget list page after successful update
        header("Location: viewbudget.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Budget</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Budget Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $budget['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" class="form-control" value="<?php echo $budget['category']; ?>" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" class="form-control" value="<?php echo $budget['amount']; ?>" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="startdate">Start Date:</label>
            <input type="date" id="startdate" name="startdate" class="form-control" value="<?php echo $budget['startdate']; ?>" required>
        </div>
        <div class="form-group">
            <label for="enddate">End Date:</label>
            <input type="date" id="enddate" name="enddate" class="form-control" value="<?php echo $budget['enddate']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" class="form-control" value="<?php echo $budget['description']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Budget</button>
        <a href="viewbudget.php" class="btn btn-primary mt-3">Go Back</a>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
