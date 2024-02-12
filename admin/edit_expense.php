<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if expense ID is provided
if (!isset($_GET['id'])) {
    echo "Expense ID not provided";
    exit();
}

$expense_id = $_GET['id'];

// Retrieve expense data from the database
$sql = "SELECT * FROM expenses WHERE id = $expense_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $expense = $result->fetch_assoc();
} else {
    echo "Expense not found";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update expense record in the database
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseCategory = $_POST['expenseCategory'];
    $expenseDescription = $_POST['expenseDescription'];
    $expenseDate = $_POST['expenseDate'];

    $sql = "UPDATE expenses SET expenseName='$expenseName', expenseAmount='$expenseAmount', expenseCategory='$expenseCategory', expenseDescription='$expenseDescription', expenseDate='$expenseDate' WHERE id=$expense_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to expense list page after successful update
        header("Location: viewexpense.php");
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
    <title>Edit Expense</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Expense</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="expenseName">Expense Name:</label>
                <input type="text" id="expenseName" name="expenseName" class="form-control" value="<?php echo $expense['expenseName']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expenseAmount">Expense Amount:</label>
                <input type="number" id="expenseAmount" name="expenseAmount" class="form-control" value="<?php echo $expense['expenseAmount']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="expenseCategory">Expense Category:</label>
                <input type="text" id="expenseCategory" name="expenseCategory" class="form-control" value="<?php echo $expense['expenseCategory']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expenseDescription">Expense Description:</label>
                <input type="text" id="expenseDescription" name="expenseDescription" class="form-control" value="<?php echo $expense['expenseDescription']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expenseDate">Expense Date:</label>
                <input type="date" id="expenseDate" name="expenseDate" class="form-control" value="<?php echo $expense['expenseDate']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Expense</button>
            <a href="viewexpense.php" class="btn btn-primary mt-3">Go Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
