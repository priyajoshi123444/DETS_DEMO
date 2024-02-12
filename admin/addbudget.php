<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Retrieve user ID from the session
    $user_id = $_SESSION['id'];

    // Retrieve form data
    $budget_name = $_POST['budget_name'];
    $category = $_POST['category'];
    $planned_amount = $_POST['planned_amount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare and execute SQL query to insert budget data
    $sql = "INSERT INTO budget (user_id, budget_name, category, planned_amount, start_date, end_date)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $budget_name, $category, $planned_amount, $start_date, $end_date);
    
    if ($stmt->execute()) {
        // Budget added successfully, redirect to viewbudget.php or any other page
        header("Location: viewbudget.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
   
} else {
    // echo "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Budget</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Add Budget</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="budget_name">Budget Name:</label>
                <input type="text" id="budget_name" name="budget_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="planned_amount">Planned Amount:</label>
                <input type="number" id="planned_amount" name="planned_amount" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Budget</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
