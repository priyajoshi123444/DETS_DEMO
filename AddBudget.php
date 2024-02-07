<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Budget - Expenses Management</title>
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

        h2 {
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
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
        <?php include 'sidebar.php'; ?>
    </div>
    <div class="container">
        <h2>Add Budget</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="budgetName">Budget Name</label>
                <input type="text" class="form-control" name="budgetName" id="budgetName" placeholder="Enter budget name" required>
            </div>

            <div class="form-group">
                <label for="budgetAmount">Budget Amount</label>
                <input type="number" class="form-control" name="budgetAmount" id="budgetAmount" placeholder="Enter budget amount" required>
            </div>

            <div class="form-group">
                <label for="budgetCategory">Budget Category</label>
                <select class="form-select" name="budgetCategory" id="budgetCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="food">Food</option>
                    <option value="utilities">Utilities</option>
                    <option value="transportation">Transportation</option>
                    <option value="entertainment">Entertainment</option>
                </select>
            </div>

            <div class="form-group">
                <label for="budgetDescription">Budget Description</label>
                <textarea class="form-control" name="budgetDescription" id="budgetDescription" rows="3" placeholder="Enter budget description"></textarea>
            </div>

            <div class="form-group">
                <label for="budgetStartDate">Budget Start Date</label>
                <input type="date" class="form-control" name="budgetStartDate" id="budgetStartDate" required>
            </div>

            <div class="form-group">
                <label for="budgetEndDate">Budget End Date</label>
                <input type="date" class="form-control" name="budgetEndDate" id="budgetEndDate" required>
            </div>
            <a href="sidebar.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Add Budget</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Expense";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $budgetName = $_POST["budgetName"];
            $budgetAmount = $_POST["budgetAmount"];
            $budgetCategory = $_POST["budgetCategory"];
            $budgetDescription = $_POST["budgetDescription"];
            $budgetStartDate = $_POST["budgetStartDate"];
            $budgetEndDate = $_POST["budgetEndDate"];

            $sql = "INSERT INTO budgets (budgetName, budgetAmount, budgetCategory, budgetDescription, budgetStartDate, budgetEndDate)
                    VALUES ('$budgetName', $budgetAmount, '$budgetCategory', '$budgetDescription', '$budgetStartDate', '$budgetEndDate')";

            if ($conn->query($sql) == TRUE) {
                echo "Budget added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>

        <script>
            function validateForm() {
                var budgetName = document.getElementById('budgetName').value;
                var budgetAmount = document.getElementById('budgetAmount').value;
                var budgetCategory = document.getElementById('budgetCategory').value;
                var budgetStartDate = document.getElementById('budgetStartDate').value;
                var budgetEndDate = document.getElementById('budgetEndDate').value;

                if (budgetName.trim() === '' || budgetAmount.trim() === '' || budgetCategory.trim() === '' || budgetStartDate.trim() === '' || budgetEndDate.trim() === '') {
                    alert('Please fill in all required fields.');
                    return false;
                }

                return true;
            }
        </script>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
