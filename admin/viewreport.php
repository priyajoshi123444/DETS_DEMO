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
$sql_users = "SELECT DISTINCT u.user_id, u.username, u.email FROM users u
                INNER JOIN expenses e ON u.user_id = e.user_id
                INNER JOIN incomes i ON u.user_id = i.user_id";
$result_users = $conn->query($sql_users);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .main {
            display: flex;
            padding-top: 70px;
        }

        h2 {
            color: black;
        }

        tr {
            color: black;
        }

        .thead {
            background-color: #b66dff;

        }

        th {
            color: white !important;
        }

        .icon {
            float: right;
            margin-right: 10px;
        }

        .pagination .page-item .page-link {
            color: black;
        }

        .expense-row {
            color: red;
            /* Set text color to red for expense rows */
        }

        .income-row {
            color: green;
            /* Set text color to green for income rows */
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
        <div class="content-wrapper">
            <div class="container mt-5">
                <h2>Combined Expense and Income Report</h2>
                <div class="table-wrapper" style="height: 1000px; width: 980px; overflow-y:auto" ;>
                    <div class="icon">
                        <div class="filter-dropdown">
                            <label for="filter">Filter by:</label>
                            <select id="filter" name="filter">
                                <option value="all">All</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <input type="submit" value="Apply" onclick="applyFilter()">
                        </div>
                    </div>
                    <script>
                        function applyFilter() {
                            var filterValue = document.getElementById('filter').value; // Get the selected filter value
                            var rows = document.querySelectorAll('.expense-row, .income-row'); // Get all rows with expense-row and income-row classes

                            rows.forEach(function (row) {
                                var type = row.querySelector('td:first-child').textContent; // Get the type of the row (Expense or Income)
                                var date = row.querySelector('td:last-child').textContent; // Get the date of the row

                                // Extract the month from the date
                                var month = new Date(date).getMonth() + 1;

                                // Check if the filter value is 'all' or matches the month
                                if (filterValue === 'all' || month === parseInt(filterValue)) {
                                    row.style.display = 'table-row'; // Show the row
                                } else {
                                    row.style.display = 'none'; // Hide the row
                                }
                            });
                        }
                    </script>



                    <?php
                    // Loop through each user who has added both expenses and income
                    while ($row_user = $result_users->fetch_assoc()) {
                        $user_id = $row_user['user_id'];
                        $user_username = $row_user['username'];
                        $user_email = $row_user['email'];

                        // Retrieve expense records for the user
                        $sql_expense = "SELECT expenseName AS name, expenseAmount AS amount, expenseCategory AS category, expenseDescription AS description, expenseDate AS date FROM expenses WHERE user_id = $user_id";
                        $result_expense = $conn->query($sql_expense);

                        // Retrieve income records for the user
                        $sql_income = "SELECT incomeName AS name, incomeAmount AS amount, incomeCategory AS category, incomeDescription AS description, incomeDate AS date FROM incomes WHERE user_id = $user_id";
                        $result_income = $conn->query($sql_income);

                        // Display user details
                        echo "<h3>User: $user_username ($user_email)</h3>";

                        // Table to display combined report
                        echo "<table class='table table-bordered '> 
                        <thead class='thead'>
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
                            echo "<tr class='expense-row'>"; // Add expense-row class
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
                            echo "<tr class='income-row'>"; // Add income-row class
                            echo "<td>Income</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>$" . $row['amount'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                        echo "<br><br><br>";
                    }
                    $results_per_page = 10; // Set the desired number of results per page
                    if (!isset($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }
                    $offset = ($page - 1) * $results_per_page;

                    ?>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                    <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
                </div>
            </div>
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