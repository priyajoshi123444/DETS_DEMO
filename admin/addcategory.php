
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST['categoryName'])) {
        // Retrieve category name and description from form
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription']; // Description is optional

        // Perform any necessary validation here

        // Connect to your database (assuming you have a connection already established)
        // Replace 'localhost', 'username', 'password', and 'database_name' with your actual database credentials
        $conn = mysqli_connect('localhost', 'root', '', 'expense_db');

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare and execute SQL query to insert category into the database
        $sql = "INSERT INTO category (name, description) VALUES ('$categoryName', '$categoryDescription')";
        if (mysqli_query($conn, $sql)) {
            echo "Category added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    } else {
        // If required fields are not filled, display an error message
        echo "Category Name is required";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System - Add Category</title>
    <style>
        .main {
            display: flex;
            padding-top: 70px;
        }
        h1 {
            color: blueviolet;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
    </style>
</head>
<body>
    <header>
        <?php include("header.php"); ?>
    </header>
    
    <div class="main">
        <sidebar>
            <?php include("sidebar.php"); ?>
        </sidebar>
        <div class="container">
            <form action="addcategory.php" method="POST">
                <h1>Add Category</h1><br>
                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name" required>
                </div>
                <div class="form-group">
                    <label for="categoryDescription">Category Description</label>
                    <input type="text" class="form-control" id="categoryDescription" name="categoryDescription" placeholder="Enter Category Description">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Category</button>
                <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
            </form>
        </div>
    </div>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
