<?php
// category.php

session_start();

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Function to establish database connection (customize according to your database credentials)
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Check if the form is submitted for adding a new category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["expenseCategory"])) {
    $categoryName = $_POST["categoryName"];

    // Insert the new category into the database
    $conn = connectToDatabase();
    $sql = "INSERT INTO expense (expenseCategory) VALUES ('$categoryName')";

    if ($conn->query($sql) === TRUE) {
        echo "Category added successfully.";
    } else {
        echo "Error adding category: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/istockphoto-1342223620-612x612.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            flex: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Category</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Enter category name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
