<?php
// Start the session
session_start();
?>
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-PyGmuM2e8y9rr8rN50IqBe4J2r+mXPH2M6Zpw/jRP1xCj0zqoqjdt0/Jl08DfP93OiA8s5RTh+H6yOr1P7OxcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* CSS code */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/images/creative-business-arrangement-with-colorful-graphics.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .container {
            width:75% !important;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap; /* Added flex-wrap */
            justify-content: space-between; /* Added */
            margin-right: 56px !important;

        }

        .box {
    width: calc(25% - 20px); /* Adjust width to fit four boxes evenly with margins */
    height: auto; /* Set height to auto to fit content */
    margin-bottom: 20px; /* Add margin at the bottom */
    padding: 10px; /* Reduce padding */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    display: inline-block; /* Display boxes inline */
    vertical-align: top; /* Align boxes to the top */
    margin-right: 20px; /* Add margin between the boxes */
}
        .box:nth-child(1) {
    background-color: #fff3cd; /* Slightly darker */
}

.box:nth-child(2) {
    background-color: #cce5ff; /* Slightly darker */
}

.box:nth-child(3) {
    background-color: #d1e7dd; /* Slightly darker */
}

.box:nth-child(4) {
    background-color: #f5c6cb; /* Slightly darker */
}


        .box i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #555;
        }

        .box h3 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #333;
        }

        .box p {
            font-size: 18px;
            margin-top: 5px;
            color: #777;
        }

        .charts-container {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .chart-container {
            flex-basis: 48%; /* Adjusted */
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100%;
            height: 350px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .progress-container {
    margin-top: 20px;
    width: 100%; /* Set width to 100% to cover the whole container */
}

.progress {
    height: 30px;
    border-radius: 5px;
    margin-bottom: 10px;
    width: 100%; /* Set width to 100% to cover the whole container */
}

.progress-bar {
    border-radius: 5px;
    width: 100%; /* Set width to 100% to cover the whole container */
}


        .progress-label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .progress-info {
            font-size: 14px;
            color: #777;
        }

        .sidebar {
            width: 250px;
            background-color: #111;
            padding-top: 20px;
            min-height: 100vh;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
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
        
    </style>
</head>
<body>
<div class="sidebar">
    <!-- Sidebar content -->
    <!-- PHP code for including sidebar -->
    <?php include 'sidebar1.php'; ?>
</div>
<div class="container">
    <!-- PHP code for box content -->
    <?php
    // Start session to access session variables
    if(!isset($_SESSION)) { 
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
    }
        // Fetch total income for the logged-in user
        $sql_total_income = "SELECT SUM(incomeAmount) AS totalIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
        $result_total_income = $conn->query($sql_total_income);
        $totalIncome = $result_total_income->fetch_assoc()['totalIncome'];

        // Fetch total monthly income for the logged-in user
        $sql_monthly_income = "SELECT SUM(incomeAmount) AS totalMonthlyIncome FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND MONTH(incomeDate) = MONTH(CURRENT_DATE())";
        $result_monthly_income = $conn->query($sql_monthly_income);
        $totalMonthlyIncome = $result_monthly_income->fetch_assoc()['totalMonthlyIncome'];

        // Fetch total expenses for the logged-in user
        $sql_total_expenses = "SELECT SUM(expenseAmount) AS totalExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";
        $result_total_expenses = $conn->query($sql_total_expenses);
        $totalExpenses = $result_total_expenses->fetch_assoc()['totalExpenses'];

        // Fetch total monthly expenses for the logged-in user
        $sql_monthly_expenses = "SELECT SUM(expenseAmount) AS totalMonthlyExpenses FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') AND MONTH(expenseDate) = MONTH(CURRENT_DATE())";
        $result_monthly_expenses = $conn->query($sql_monthly_expenses);
        $totalMonthlyExpenses = $result_monthly_expenses->fetch_assoc()['totalMonthlyExpenses'];

        // Fetch monthly income vs. expenses data for the logged-in user
        $sql_monthly_data = "SELECT 
                                MONTHNAME(expenseDate) AS month, 
                                SUM(incomeAmount) AS income, 
                                SUM(expenseAmount) AS expenses 
                            FROM 
                                incomes 
                            LEFT JOIN 
                                expenses 
                            ON 
                                MONTH(incomes.incomeDate) = MONTH(expenses.expenseDate) 
                            WHERE 
                                incomes.user_id = (SELECT user_id FROM users WHERE email = '$email') 
                            GROUP BY 
                                MONTH(incomes.incomeDate)";
        $result_monthly_data = $conn->query($sql_monthly_data);

        $monthly_data = [];
        $all_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Initialize monthly data array with all months and set initial values to 0
        foreach ($all_months as $month) {
            $monthly_data[$month] = [
                'income' => 0,
                'expenses' => 0
            ];
        }

        // Update monthly data with fetched data from the database
        while ($row = $result_monthly_data->fetch_assoc()) {
            $month_name = $row['month'];
            $monthly_data[$month_name] = [
                'income' => $row['income'],
                'expenses' => $row['expenses']
            ];
        }

        // Fetch expenses by categories for the logged-in user
        $sql_expense_categories = "SELECT 
                                        expenseCategory, 
                                        SUM(expenseAmount) AS totalExpense 
                                    FROM 
                                        expenses 
                                    WHERE 
                                        user_id = (SELECT user_id FROM users WHERE email = '$email') 
                                    AND 
                                        expenseCategory IN 
                                            (SELECT DISTINCT category FROM budgets WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')) 
                                    GROUP BY 
                                        expenseCategory";
        $result_expense_categories = $conn->query($sql_expense_categories);
        $expense_categories = [];
        while ($row = $result_expense_categories->fetch_assoc()) {
            $expense_categories[$row['expenseCategory']] = $row['totalExpense'];
        }
        
        // Calculate percentage of expenses for each category relative to the total expenses
        $total_expenses = array_sum($expense_categories);
        $category_percentages = [];
        foreach ($expense_categories as $category => $amount) {
            $category_percentages[$category] = ($amount / $total_expenses) * 100;
        }
    ?>
    <div class="box">
        <i class="fas fa-dollar-sign"></i>
        <h3>Total Income</h3>
        <p id="totalIncome"><?php echo $totalIncome; ?></p>
    </div>

    <div class="box">
        <i class="far fa-calendar-alt"></i>
        <h3>Total Monthly Income</h3>
        <p id="totalMonthlyIncome"><?php echo $totalMonthlyIncome; ?></p>
    </div>
    <div class="box">
    <i class="fas fa-coins"></i>
    <h3>Total Expenses</h3>
    <p id="totalExpenses" <?php echo ($totalExpenses > $totalIncome) ? 'style="color: red;"' : ''; ?>><?php echo $totalExpenses; ?></p>
</div>

<div class="box">
    <i class="far fa-calendar-times"></i>
    <h3>Total Monthly Expenses</h3>
    <p id="totalMonthlyExpenses" <?php echo ($totalMonthlyExpenses > $totalMonthlyIncome) ? 'style="color: red;"' : ''; ?>><?php echo $totalMonthlyExpenses; ?></p>
</div>


    <div class="charts-container">
        <div class="chart-container">
            <!-- Bar Graph for Monthly Income vs Expenses -->
            <canvas id="monthlyBarChart"></canvas>
        </div>
        <div class="chart-container">
            <!-- Pie Chart for Expenses by Categories -->
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <!-- Progress bars for expense categories -->
    <div class="progress-container">
        <h2>Budget Status by Category</h2>
        <?php
        // Check if there are any budgeted categories
        if (!empty($category_percentages)) {
            foreach ($category_percentages as $category => $percentage): ?>
                <div class="progress-label"><?php echo $category; ?></div>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage; ?>%" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-info"><?php echo number_format($percentage, 2); ?>%</div>
            <?php endforeach;
        } else {
            echo "<p>No budgeted categories found.</p>";
        }
        ?>
    </div>
</div>

<script>
    // Get the context of the canvas elements
    var ctxMonthly = document.getElementById('monthlyBarChart').getContext('2d');
    var ctxPie = document.getElementById('pieChart').getContext('2d');

    // Function to update charts with data directly from PHP
    function updateCharts() {
        // Dummy data for demonstration
        var data = {
            totalMonthlyIncome: <?php echo $totalMonthlyIncome; ?>,
            monthlyData: <?php echo json_encode($monthly_data); ?>,
            expenseCategories: <?php echo json_encode($expense_categories); ?>
        };

        // Update total monthly income
        document.getElementById('totalMonthlyIncome').innerText = data.totalMonthlyIncome;

        // Update monthly bar chart
        var monthlyBarChart = new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: Object.keys(data.monthlyData),
                datasets: [{
                    label: 'Income',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: Object.values(data.monthlyData).map(item => item.income),
                }, {
                    label: 'Expenses',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: Object.values(data.monthlyData).map(item => item.expenses),
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

        // Update pie chart
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: Object.keys(data.expenseCategories),
                datasets: [{
                    label: 'Expenses by Category',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    data: Object.values(data.expenseCategories),
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
    }

    // Update charts on page load
    updateCharts();
    // Set interval to update charts periodically
    setInterval(updateCharts, 5000); // Update every 5 seconds (adjust as needed)
</script>
</body>
</html>
