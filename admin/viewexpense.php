<?php
session_start();
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
            color: white;
        }

        .icon {
            float: right;
            margin-right: 10px;
        }

        .pagination .page-item .page-link {
            color: black;
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
            <h2>View Expenses</h2>
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
                    var filterValue = document.getElementById('filter').value;
                    var expenses = document.querySelectorAll('.expense-row');

                    expenses.forEach(function (expense) {
                        if (filterValue === 'all') {
                            expense.style.display = 'table-row';
                        } else {
                            var date = new Date(expense.querySelector('.expense-date').textContent);
                            if (date.getMonth() + 1 === parseInt(filterValue)) {
                                expense.style.display = 'table-row';
                            } else {
                                expense.style.display = 'none';
                            }
                        }
                    });
                }
            </script>
            <?php
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

            // SQL query to fetch users who have added expenses
            $sql = "SELECT DISTINCT users.user_id AS user_id, users.username AS username, users.email AS email FROM users INNER JOIN expenses ON users.user_id = expenses.user_id";

            // echo $sql;
            $result = $conn->query($sql);

            // Check if any users exist
            if ($result->num_rows > 0) {
                // Output data of each user
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    $userId = $row["user_id"];
                    $username = $row["username"];
                    $email = $row["email"];

                    // SQL query to fetch expenses for the current user
                    $expenseSql = "SELECT * FROM expenses WHERE user_id = $userId";
                    $expenseResult = $conn->query($expenseSql);

                    // SQL query to fetch income for the current user
                    $incomeSql = "SELECT * FROM incomes WHERE user_id = $userId";
                    $incomeResult = $conn->query($incomeSql);

                    // Check if any expenses exist for the current user
                    if ($expenseResult->num_rows > 0) {
                        echo "<h3>User: $username ($email)</h3>";
                        // Output table for expenses
                        echo "<table class='table table-bordered table-hover'>";
                        echo "<thead class='thead'>";
                        echo "<tr>";
                        echo "<th>User ID</th>";
                        echo "<th>Expense Name</th>";
                        echo "<th>Amount</th>";
                        echo "<th>Category</th>";
                        echo "<th>Description</th>";
                        echo "<th>Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Output data of each expense
                        $totalExpense = 0; // Initialize total expense for the user
                        while ($expenseRow = $expenseResult->fetch_assoc()) {
                            echo "<tr class='expense-row'>";
                            echo "<td>" . $expenseRow["user_id"] . "</td>";
                            echo "<td>" . $expenseRow["expenseName"] . "</td>";
                            echo "<td>" . $expenseRow["expenseAmount"] . "</td>";
                            echo "<td>" . $expenseRow["expenseCategory"] . "</td>";
                            echo "<td>" . $expenseRow["expenseDescription"] . "</td>";
                            echo "<td class='expense-date'>" . $expenseRow["expenseDate"] . "</td>";
                            echo "</tr>";

                            // Add the expense amount to the total expense
                            $totalExpense += $expenseRow["expenseAmount"];
                        }

                        // Output data of each income
                        $totalIncome = 0; // Initialize total income for the user
                        while ($incomeRow = $incomeResult->fetch_assoc()) {
                            // Add the income amount to the total income
                            $totalIncome += $incomeRow["incomeAmount"];
                        }

                        // Display the total expense for the user
                        echo "<tr>";
                        echo "<td colspan='2'>Total Expense</td>";
                        echo "<td>$totalExpense</td>";
                        echo "<td colspan='3'></td>"; // colspan='3' to span the remaining columns
                        echo "</tr>";

                        // Display the total income for the user
                        echo "<tr>";
                        echo "<td colspan='2'>Total Income</td>";
                        echo "<td>$totalIncome</td>";
                        echo "<td colspan='3'></td>"; // colspan='3' to span the remaining columns
                        echo "</tr>";

                        // Check if total expense is greater than total income
                        if ($totalExpense > $totalIncome) {
                            echo "<tr>";
                            echo "<td colspan='6' style='color: red;'>Warning: Total Expense is greater than Total Income!</td>";
                            echo "</tr>";
                            echo "<script>alert('Warning: Total Expense is greater than Total Income for user: $username!');</script>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No expenses found for user: $username ($email)</p>";
                    }
                    echo "<br><br><br>";
                }

            } else {
                echo "<p>No users found.</p>";
            }
            // Pagination variables
            $results_per_page = 10; // Set the desired number of results per page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $offset = ($page - 1) * $results_per_page;
            if (!$result) {
                die("Error: " . $conn->error);
            }


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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>