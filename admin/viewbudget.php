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

        .exceeded {
            color: red;
            font-weight: bold;
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
        <h2>View Budget</h2>

        <div class="icon">
            <div class="filter-dropdown">
                <label for="filter">Filter by Category:</label>
                <select id="filter" name="filter">
                    <option value="all">All</option>
                    <?php
                    // Fetch distinct categories from the budgets table
                    $categorySql = "SELECT DISTINCT category FROM budgets";
                    $categoryResult = $conn->query($categorySql);
                    if ($categoryResult->num_rows > 0) {
                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                            echo "<option value='" . $categoryRow['category'] . "'>" . $categoryRow['category'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Apply" onclick="applyFilter()">
            </div>
        </div>

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

        // SQL query to fetch users who have set budgets
        $sql = "SELECT DISTINCT users.user_id AS user_id, users.username AS username, users.email AS email FROM users INNER JOIN budgets ON users.user_id = budgets.user_id";
        $result = $conn->query($sql);

        // Check if any users exist
        if ($result->num_rows > 0) {
            // Output data of each user
            while ($row = $result->fetch_assoc()) {
                $userId = $row["user_id"];
                $username = $row["username"];
                $email = $row["email"];

                // SQL query to fetch budget for the current user
                $budgetSql = "SELECT * FROM budgets WHERE user_id = $userId";
                $budgetResult = $conn->query($budgetSql);

                // Check if any budget exist for the current user
                if ($budgetResult->num_rows > 0) {
                    echo "<h3>User: $username ($email)</h3>";
                    // Output table for budget
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<thead class='thead'>";
                    echo "<tr>";
                    echo "<th>User ID</th>";
                    echo "<th>Category</th>";
                    echo "<th>Planned Amount</th>";
                    echo "<th>Actual Amount</th>";
                    echo "<th>Start Date</th>";
                    echo "<th>End Date</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Output data of each budget
                    while ($budgetRow = $budgetResult->fetch_assoc()) {
                        echo "<tr class='budget-row'>"; // Add class for targeting rows in JavaScript
                        echo "<td>" . $budgetRow["user_id"] . "</td>";
                        echo "<td class='budget-category'>" . $budgetRow["category"] . "</td>"; // Add class for category column
                        echo "<td>" . $budgetRow["planned_amount"] . "</td>";

                        // SQL query to fetch total expense for the current category
                        $totalExpenseSql = "SELECT SUM(expenseAmount) AS totalExpense FROM expenses WHERE user_id = $userId AND expenseCategory = '" . $budgetRow["category"] . "'";
                        $totalExpenseResult = $conn->query($totalExpenseSql);
                        $totalExpenseRow = $totalExpenseResult->fetch_assoc();
                        $totalExpense = $totalExpenseRow["totalExpense"];

                        if ($totalExpense > $budgetRow["planned_amount"]) {
                            // If exceeded, add class for styling
                            echo "<td class='exceeded'>" . $totalExpense . "</td>";
                            // Show alert
                            echo "<script>alert('Total expense exceeds planned amount for category: " . $budgetRow["category"] . "');</script>";
                        } else {
                            echo "<td>" . $totalExpense . "</td>";
                        }
                        echo "<td>" . $budgetRow["start_date"] . "</td>";
                        echo "<td>" . $budgetRow["end_date"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No budget found for user: $username ($email)</p>";
                }
                echo "<br><br><br>";
            }
        } else {
            echo "<p>No users found.</p>";
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

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<footer>
    <?php include("footer.php"); ?>
</footer>

<script>
    function applyFilter() {
        var filterValue = document.getElementById('filter').value;
        var budgets = document.querySelectorAll('.budget-row');

        budgets.forEach(function (budget) {
            var category = budget.querySelector('.budget-category').textContent.trim();
            if (filterValue === 'all' || category === filterValue) {
                budget.style.display = 'table-row';
            } else {
                budget.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
