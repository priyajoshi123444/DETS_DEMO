<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income - Income Management</title>
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
        <h2>Add Income</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="incomeName">Income Name</label>
                <input type="text" class="form-control" name="incomeName" id="incomeName" placeholder="Enter income name" required>
            </div>

            <div class="form-group">
                <label for="incomeAmount">Income Amount</label>
                <input type="number" class="form-control" name="incomeAmount" id="incomeAmount" placeholder="Enter income amount" required>
            </div>

            <div class="form-group">
                <label for="incomeCategory">Income Category</label>
                <select class="form-select" name="incomeCategory" id="incomeCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="salary">Salary</option>
                    <option value="business">Business</option>
                    <option value="freelance">Freelance</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="incomeDescription">Income Description</label>
                <textarea class="form-control" name="incomeDescription" id="incomeDescription" rows="3" placeholder="Enter income description"></textarea>
            </div>

            <div class="form-group">
                <label for="incomeDate">Income Date</label>
                <input type="date" class="form-control" name="incomeDate" id="incomeDate" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Income</button>
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

            $incomeName = $_POST["incomeName"];
            $incomeAmount = $_POST["incomeAmount"];
            $incomeCategory = $_POST["incomeCategory"];
            $incomeDescription = $_POST["incomeDescription"];
            $incomeDate = $_POST["incomeDate"];

            $sql = "INSERT INTO income (incomeName, incomeAmount, incomeCategory, incomeDescription, incomeDate)
                    VALUES ('$incomeName', $incomeAmount, '$incomeCategory', '$incomeDescription', '$incomeDate')";

            if ($conn->query($sql) == TRUE) {
                echo "Income added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var incomeName = document.getElementById('incomeName').value;
            var incomeAmount = document.getElementById('incomeAmount').value;
            var incomeCategory = document.getElementById('incomeCategory').value;
            var incomeDate = document.getElementById('incomeDate').value;

            if (incomeName.trim() === '' || incomeAmount.trim() === '' || incomeCategory.trim() === '' || incomeDate.trim() === '') {
                alert('Please fill in all required fields.');
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
