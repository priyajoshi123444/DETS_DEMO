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

// Check if income ID is provided
if (!isset($_GET['id'])) {
    echo "Income ID not provided";
    exit();
}

$income_id = $_GET['id'];

// Retrieve income data from the database
$sql = "SELECT * FROM income WHERE id = $income_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $income = $result->fetch_assoc();
} else {
    echo "Income not found";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update income record in the database
    $incomeName = $_POST['incomeName'];
    $incomeAmount = $_POST['incomeAmount'];
    $incomeCategory = $_POST['incomeCategory'];
    $incomeDescription = $_POST['incomeDescription'];
    $incomeDate = $_POST['incomeDate'];

    $sql = "UPDATE income SET incomeName='$incomeName', incomeAmount='$incomeAmount', incomeCategory='$incomeCategory', incomeDescription='$incomeDescription', incomeDate='$incomeDate' WHERE id=$income_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to income list page after successful update
        header("Location: viewincome.php");
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
    <title>Edit Income</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Income</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="incomeName">Income Name:</label>
                <input type="text" id="incomeName" name="incomeName" class="form-control" value="<?php echo $income['incomeName']; ?>" required>
            </div>
            <div class="form-group">
                <label for="incomeAmount">Income Amount:</label>
                <input type="number" id="incomeAmount" name="incomeAmount" class="form-control" value="<?php echo $income['incomeAmount']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="incomeCategory">Income Category:</label>
                <input type="text" id="incomeCategory" name="incomeCategory" class="form-control" value="<?php echo $income['incomeCategory']; ?>" required>
            </div>
            <div class="form-group">
                <label for="incomeDescription">Income Description:</label>
                <input type="text" id="incomeDescription" name="incomeDescription" class="form-control" value="<?php echo $income['incomeDescription']; ?>" required>
            </div>
            <div class="form-group">
                <label for="incomeDate">Income Date:</label>
                <input type="date" id="incomeDate" name="incomeDate" class="form-control" value="<?php echo $income['incomeDate']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Income</button>
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
