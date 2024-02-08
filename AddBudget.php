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
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Add Budget</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="budgetName">Budget Name</label>
                <input type="text" class="form-control" name="budget_name" id="budgetName" placeholder="Enter budget name" required>
            </div>

            <div class="form-group">
                <label for="actualamount">Actual Amount</label>
                <input type="number" class="form-control" name="actual_amount" id="actualamount" placeholder="Enter budget amount" required>
            </div>

            <div class="form-group">
    <label for="plannedAmount">Planned Amount</label>
    <input type="number" class="form-control" name="planned_amount" id="plannedAmount" placeholder="Enter planned amount" required>
</div>


            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-select" name="category" id="category" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="food">Food</option>
                    <option value="utilities">Utilities</option>
                    <option value="transportation">Transportation</option>
                    <option value="entertainment">Entertainment</option>
                </select>
            </div>


            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" name="start_date" id="startDate" required>
            </div>

            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" name="end_date" id="endDate" required>
            </div>

            <a href="sidebar1.php" class="btn btn-secondary btn-go-back">Go Back</a>
            <button type="submit" class="btn btn-primary">Add Budget</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();

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
            $sql_user_id = "SELECT user_id FROM user WHERE email = '$email'";
            $result_user_id = $conn->query($sql_user_id);

            if ($result_user_id->num_rows > 0) {
                $row_user_id = $result_user_id->fetch_assoc();
                $user_id = $row_user_id['user_id'];

                // Fetch other form data
                $budgetName = $_POST["budget_name"];
                $actualamount = $_POST["actual_amount"];
                $category = $_POST["category"];
                $planedamount = $_POST["planned_amount"];
                $startDate = $_POST["start_date"];
                $endDate = $_POST["end_date"];

                // Construct SQL query to insert budget
                $sql = "INSERT INTO budget (budget_name, actual_amount, category, planned_amount, start_date, end_date, user_id) VALUES ('$budgetName', '$actualamount', '$category', '$planedamount', '$startDate', '$endDate', '$user_id')";

                // Execute SQL query to insert budget
                if ($conn->query($sql) === TRUE) {
                    echo "Budget added successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "<p>User not found.</p>";
            }

            // Close database connection
            $conn->close();
        }
        ?>

        <script>
            function validateForm() {
                var budgetName = document.getElementById('budgetName').value;
               var actualamount = document.getElementById('actual_amount').value;
               var planedamount = document.getElementById('planned_amount').value;
                var category = document.getElementById('category').value;
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;

                if (budgetName.trim() === '' || actualamount.trim() === '' || planedamount.trim() ==='' || category.trim() === '' || startDate.trim() === '' || endDate.trim() === '') {
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
