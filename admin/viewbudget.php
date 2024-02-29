<?php
session_start();
// echo"sakshi";
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
        .main{
            display: flex;
            padding-top: 70px ;
        }
        h2{
            color: blueviolet;
        }
        tr{
            color: blue;
        }
        /* .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        } */
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
        <div class="container mt-5">
            <h2>View Budget</h2>
            <div class="icon">
    <div class="filter-dropdown">
        <label for="filter">Filter by:</label>
        <select id="filter" name="filter">
            <option value="all">All</option>
            <option value="yearly">Yearly</option>
            <option value="monthly">Monthly</option>
        </select>
        <input type="submit" value="Apply" onclick="applyFilter()">
    </div>
</div>
<script>
    function applyFilter() {
        var filterValue = document.getElementById('filter').value;
        var budgets = document.querySelectorAll('.budget-row');

        budgets.forEach(function(budget) {
            if (filterValue === 'all') {
                budget.style.display = 'table-row';
            } else if (filterValue === 'yearly') {
                var startDate = new Date(budget.querySelector('.start-date').textContent);
                var endDate = new Date(budget.querySelector('.end-date').textContent);
                var currentDate = new Date();

                if (startDate.getFullYear() <= currentDate.getFullYear() && endDate.getFullYear() >= currentDate.getFullYear()) {
                    budget.style.display = 'table-row';
                } else {
                    budget.style.display = 'none';
                }
            } else if (filterValue === 'monthly') {
                var startDate = new Date(budget.querySelector('.start-date').textContent);
                var endDate = new Date(budget.querySelector('.end-date').textContent);
                var currentDate = new Date();

                if (startDate.getMonth() <= currentDate.getMonth() && endDate.getMonth() >= currentDate.getMonth()) {
                    budget.style.display = 'table-row';
                } else {
                    budget.style.display = 'none';
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
                        echo "<thead class='thead-sucess'>";
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
                            echo "<tr>";
                            echo "<td>" . $budgetRow["user_id"] . "</td>";
                            echo "<td>" . $budgetRow["category"] . "</td>";
                            echo "<td>" . $budgetRow["planned_amount"] . "</td>";
                        
                            // SQL query to fetch total expense for the current category
                            $totalExpenseSql = "SELECT SUM(expenseAmount) AS totalExpense FROM expenses WHERE user_id = $userId AND expenseCategory = '" . $budgetRow["category"] . "'";
                            $totalExpenseResult = $conn->query($totalExpenseSql);
                            $totalExpenseRow = $totalExpenseResult->fetch_assoc();
                            $totalExpense = $totalExpenseRow["totalExpense"];
                        
                            // Check if total expense exceeds planned amount
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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
