<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts - Income and Expenses</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/images/istockphoto-1342223620-612x612.jpg');
            /* Replace 'background.jpg' with your actual background image path */
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
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


        h3 {
            margin: 10px 0;
            text-align: center;
        }

        .total-box {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
            max-width: 600px;
            display: flex;
            justify-content: space-between;
        }

        .chart-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .chart-container {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: calc(50% - 20px);
    max-width: 400px; /* Increased max-width */
}

.chart-container canvas {
    width: 100% !important;
    height: auto !important;
}
    </style>
</head>
<body>
<div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
<div class="container">
    <?php
    // Start session to access session variables
   if(!isset($_SESSION)) 
   { 
       session_start(); 
   } 
    // Include database connection
    include 'connection.php';

    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        // Redirect to login page or display an error message
        echo "<script>alert('You are not logged in. Please login to view your data.');</script>";
    } else {
        // Get the logged-in user's email from the session
        $email = $_SESSION['email'];

        // Fetch income data for the logged-in user
        $sql_income = "SELECT SUM(incomeAmount) AS totalIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
        $result_income = $conn->query($sql_income);
        $row_income = $result_income->fetch_assoc();
        $totalIncome = $row_income['totalIncome'];

        // Fetch expenses data for the logged-in user
        $sql_expenses = "SELECT SUM(expenseAmount) AS totalExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
        $result_expenses = $conn->query($sql_expenses);
        $row_expenses = $result_expenses->fetch_assoc();
        $totalExpenses = $row_expenses['totalExpenses'];

        // Fetch income data for the logged-in user by category
        $sql_income_category = "SELECT incomeCategory, SUM(incomeAmount) AS totalIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') GROUP BY incomeCategory";
        $result_income_category = $conn->query($sql_income_category);

        // Fetch expenses data for the logged-in user by category
        $sql_expenses_category = "SELECT expenseCategory, SUM(expenseAmount) AS totalExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') GROUP BY expenseCategory";
        $result_expenses_category = $conn->query($sql_expenses_category);

        // Prepare data for charts
        $incomeData = [];
        $expensesData = [];

        // Convert fetched data into JavaScript format
        while ($row = $result_income_category->fetch_assoc()) {
            $incomeData[$row['incomeCategory']] = $row['totalIncome'];
        }

        while ($row = $result_expenses_category->fetch_assoc()) {
            $expensesData[$row['expenseCategory']] = $row['totalExpenses'];
        }

        // Output income and expenses data in JavaScript format
        echo '<div class="total-box">';
        echo "<h3>Total Income: $totalIncome</h3>";
        echo "<h3>Total Expenses: $totalExpenses</h3>";
        echo '</div>';

        // Bar Chart (Horizontal)
        echo '<div class="chart-wrapper">';
        echo '<div class="chart-container">';
        echo '<canvas id="barChart"></canvas>';
        echo '</div>';

        // Pie Chart
        echo '<div class="chart-container">';
        echo '<canvas id="pieChart"></canvas>';
        echo '</div>';

        // Line Chart
        echo '<div class="chart-container">';
        echo '<canvas id="lineChart"></canvas>';
        echo '</div>';

        // Budget Chart
        echo '<div class="chart-container">';
        echo '<canvas id="budgetChart"></canvas>';
        echo '</div>';
        echo '</div>'; // End of chart-wrapper
    }
    ?>
</div>

<script>
    // Bar Chart (Horizontal)
    var barChartCtx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($expensesData)); ?>,
            datasets: [{
                label: 'Expenses',
                data: <?php echo json_encode(array_values($expensesData)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // Display bar chart horizontally
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    var pieChartCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($expensesData)); ?>,
            datasets: [{
                label: 'Expenses',
                data: <?php echo json_encode(array_values($expensesData)); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Line Chart
    var lineChartCtx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(lineChartCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($incomeData)); ?>,
            datasets: [{
                label: 'Income',
                data: <?php echo json_encode(array_values($incomeData)); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'Expenses',
                data: <?php echo json_encode(array_values($expensesData)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Budget Chart
    var budgetChartCtx = document.getElementById('budgetChart').getContext('2d');
    var budgetChart = new Chart(budgetChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                label: 'Budget',
                data: [<?php echo $totalIncome; ?>, <?php echo $totalExpenses; ?>],
                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
