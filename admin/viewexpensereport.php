<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
    </style>
</head>

<body>

    <header>
        <?php
        include("header.php");
        ?>
    </header>
    <div class="main">
        <sidebar>
            <?php
            include("sidebar.php");
            ?>
        </sidebar>
        <div class="content-wrapper">
        <div class="container mt-5">

            <h2>View Expenses Reports</h2>
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

    expenses.forEach(function(expense) {
        var date = new Date(expense.querySelector('.expense-date').textContent);
        // Simplified the condition to check if the filter value is 'all'
        if (filterValue === 'all' || date.getMonth() + 1 === parseInt(filterValue)) {
            expense.style.display = 'table-row';
        } else {
            expense.style.display = 'none';
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
            $result = $conn->query($sql);

            // Check if any users exist
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    $userId = $row["user_id"];
                    $username = $row["username"];
                    $email = $row["email"];
                
                    // SQL query to fetch expenses for the current user
                    $expenseSql = "SELECT * FROM expenses WHERE user_id = $userId";
                    $expenseResult = $conn->query($expenseSql);
                
                    // Check if any expenses exist for the current user
                    if ($expenseResult->num_rows > 0) {
                        echo "<h3>User: $username ($email)</h3>";
                        echo "<table class='table table-bordered table-striped'>";
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
                        while ($expenseRow = $expenseResult->fetch_assoc()) {
                            echo "<tr class='expense-row'>";
                            echo "<td>" . $expenseRow["user_id"] . "</td>";
                            echo "<td>" . $expenseRow["expenseName"] . "</td>";
                            echo "<td>" . $expenseRow["expenseAmount"] . "</td>";
                            echo "<td>" . $expenseRow["expenseCategory"] . "</td>";
                            echo "<td>" . $expenseRow["expenseDescription"] . "</td>";
                            echo "<td class='expense-date'>" . $expenseRow["expenseDate"] . "</td>"; 
                            echo "</tr>";
                        }
                
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No expenses found for user: $username ($email)</p>";
                    }
                    echo "<br><br><br>";
                }
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
            <!-- Button to go back or perform other actions -->
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </div>
    </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- <script>
        function generatePDF() {
            // Create a new jsPDF instance
            var doc = new jsPDF();

            // Add content to the PDF
            doc.text('Expense Report', 10, 10);
            // ... Add more content as needed ...

            // Save the PDF with a specific name
            doc.save('expense_report.pdf');
        }
    </script> -->
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>