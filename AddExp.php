<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expenses - Expenses Management</title>
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
        <h2>Add Expenses</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="expenseName">Expense Name</label>
                <input type="text" class="form-control" name="expenseName" id="expenseName" placeholder="Enter expense name" required>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Expense Amount</label>
                <input type="number" class="form-control" name="expenseAmount" id="expenseAmount" placeholder="Enter expense amount" required>
            </div>

            <div class="form-group">
                <label for="expenseCategory">Expense Category</label>
                <select class="form-select" name="expenseCategory" id="expenseCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="food">Food</option>
                    <option value="utilities">Utilities</option>
                    <option value="transportation">Transportation</option>
                    <option value="entertainment">Entertainment</option>
                </select>
            </div>

            <div class="form-group">
                <label for="expenseDescription">Expense Description</label>
                <textarea class="form-control" name="expenseDescription" id="expenseDescription" rows="3" placeholder="Enter expense description"></textarea>
            </div>

            <div class="form-group">
                <label for="expenseDate">Expense Date</label>
                <input type="date" class="form-control" name="expenseDate" id="expenseDate" required>
            </div>

            <div class="form-group">
                <label for="billImage">Bill Image</label>
                <input type="file" class="form-control" name="billImage" id="billImage">
                <small class="form-text text-muted">Upload a photo of your bill.</small>
            </div>

            <a href="sidebar.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Add Expense</button>
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

            $expenseName = $_POST["expenseName"];
            $expenseAmount = $_POST["expenseAmount"];
            $expenseCategory = $_POST["expenseCategory"];
            $expenseDescription = $_POST["expenseDescription"];
            $expenseDate = $_POST["expenseDate"];
            $billImage = isset($_FILES["billImage"]) ? $_FILES["billImage"]["name"] : "";

            $sql = "INSERT INTO expenses (expenseName, expenseAmount, expenseCategory, expenseDescription, expenseDate, billImage)
                    VALUES ('$expenseName', $expenseAmount, '$expenseCategory', '$expenseDescription', '$expenseDate', '$billImage')";

            if ($conn->query($sql) == TRUE) {
                echo "Expense added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            if (!empty($billImage)) {
                $targetDir = "uploads/";  // Specify the directory where you want to store uploaded files
                $targetFile = $targetDir . basename($_FILES["billImage"]["name"]);

                move_uploaded_file($_FILES["billImage"]["tmp_name"], $targetFile);
                echo "File uploaded successfully.";
            }
        }
        ?>

        <script>
            function validateForm() {
                var expenseName = document.getElementById('expenseName').value;
                var expenseAmount = document.getElementById('expenseAmount').value;
                var expenseCategory = document.getElementById('expenseCategory').value;
                var expenseDate = document.getElementById('expenseDate').value;

                if (expenseName.trim() === '' || expenseAmount.trim() === '' || expenseCategory.trim() === '' || expenseDate.trim() === '') {
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
