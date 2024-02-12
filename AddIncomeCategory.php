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
        .sidebar {
            width: 250px;
            background-color: #111;
            padding-top: 20px;
            height: 100%;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
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
<div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Add Income Category</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Enter category name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>

        <?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Include database connection
include 'Connection.php';

// Fetch user ID based on email
$sql_id = "SELECT user_id FROM user WHERE email = '$email'";
$result_id = $conn->query($sql_id);

if ($result_id->num_rows > 0) {
    $row_id = $result_id->fetch_assoc();
    $user_id = $row_id['user_id'];

    // PHP code for handling form submission and database insertion
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch category name from the form
        $categoryName = $_POST["categoryName"];

        // Construct SQL query to insert category
        $sql = "INSERT INTO income_categories (category_name, user_id) VALUES ('$categoryName', '$user_id')";

        // Execute SQL query to insert category
        if ($conn->query($sql) === TRUE) {
            echo "Category added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "<p>User not found.</p>";
}

// Close database connection
$conn->close();
?>


    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
