<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all users who have added both expenses and income
$sql_users = "SELECT DISTINCT u.id, u.username, u.email FROM users u
                INNER JOIN expenses e ON u.id = e.user_id
                INNER JOIN income i ON u.id = i.user_id";
$result_users = $conn->query($sql_users);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Expense and Income Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
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

        h2 {
            color: blueviolet;
            margin-bottom: 20px;
        }

        .nav-tabs {
            margin-bottom: 20px;
            position: relative;
        }

        .pdf-icon {
            font-size: 1.5em;
            color: red;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .main{
            display: flex;
            padding-top: 70px ;
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
        <div class="container mt-5">
            <h2>Combined Expense and Income Report</h2>
            <!-- Tab navigation for expenses and income reports -->
        <ul class="nav nav-tabs">
          
          <!-- PDF icon for generating PDF report -->
          <i class="fas fa-file-pdf pdf-icon" onclick="generatePDF()"></i>
      </ul>

            <?php
            // Loop through each user who has added both expenses and income
            while ($row_user = $result_users->fetch_assoc()) {
                $user_id = $row_user['id'];
                $user_username = $row_user['username'];
                $user_email = $row_user['email'];

                // Retrieve expense records for the user
                $sql_expense = "SELECT expenseName AS name, expenseAmount AS amount, expenseCategory AS category, expenseDescription AS description, expenseDate AS date FROM expenses WHERE user_id = $user_id";
                $result_expense = $conn->query($sql_expense);

                // Retrieve income records for the user
                $sql_income = "SELECT incomeName AS name, incomeAmount AS amount, incomeCategory AS category, incomeDescription AS description, incomeDate AS date FROM income WHERE user_id = $user_id";
                $result_income = $conn->query($sql_income);

                // Display user details
                echo "<h3>User: $user_username ($user_email)</h3>";

                // Table to display combined report
                echo "<table class='table table-bordered table-striped'> 
                        <thead class='thead-sucess'>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>";

                // Output expense records
                while ($row = $result_expense->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>Expense</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>$" . $row['amount'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }

                // Output income records
                while ($row = $result_income->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>Income</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>$" . $row['amount'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            }

          
            ?>
            
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
