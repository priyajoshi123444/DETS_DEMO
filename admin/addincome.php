<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Include database connection file
// include('database.php'); // Replace with the actual filename

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission

    // Retrieve form data
    $incomeName = $_POST['incomeName'];
    $incomeAmount = $_POST['incomeAmount'];
    $incomeCategory = $_POST['incomeCategory'];
    $incomeDescription = $_POST['incomeDescription'];
    $incomeDate = $_POST['incomeDate'];
    $userId = $_SESSION['id']; // Retrieve user ID from session

    // Validate form data (perform validation as needed)

    // Insert income into the database
    $sql = "INSERT INTO income (user_id, incomeName, incomeAmount, incomeCategory, incomeDescription, incomeDate) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $userId, $incomeName, $incomeAmount, $incomeCategory, $incomeDescription, $incomeDate);
    $stmt->execute();

    // Check if income was successfully added
    if ($stmt->affected_rows > 0) {
        // Income added successfully
        // Redirect to view income page or show a success message
        header("Location: viewincome.php");
        exit();
    } else {
        // Handle case where income addition failed
        // Redirect to an error page or display an error message
        exit("Failed to add income.");
    }
}

// Close database connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Add Income</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="incomeName">Income Name:</label>
                <input type="text" id="incomeName" name="incomeName" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="incomeAmount">Income Amount:</label>
                <input type="number" id="incomeAmount" name="incomeAmount" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="incomeCategory">Income Category:</label>
                <input type="text" id="incomeCategory" name="incomeCategory" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="incomeDescription">Income Description:</label>
                <input type="text" id="incomeDescription" name="incomeDescription" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="incomeDate">Income Date:</label>
                <input type="date" id="incomeDate" name="incomeDate" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Income</button>
            <a href="index.php" class="btn btn-primary ">Go Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
