<?php
// Start session to access session variables
session_start();

// Include database connection
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Fetch user ID based on email
$user_id_sql = "SELECT user_id FROM users WHERE email = '$email'";
$user_id_result = $conn->query($user_id_sql);

// Check if user ID was fetched successfully
if ($user_id_result->num_rows > 0) {
    $user_id_row = $user_id_result->fetch_assoc();
    $user_id = $user_id_row['user_id'];
} else {
    // Handle error if user ID not found
    echo "Error: User ID not found.";
    exit();
}

// Fetch income and expenses for the logged-in user
$income_sql = "SELECT incomeAmount, incomeCategory FROM incomes WHERE user_id = '$user_id'";
$income_result = $conn->query($income_sql);

$expense_sql = "SELECT expenseAmount, expenseCategory FROM expenses WHERE user_id = '$user_id'";
$expense_result = $conn->query($expense_sql);

// Process income data
$income_data = [];
while ($row = $income_result->fetch_assoc()) {
    $category = $row['incomeCategory'];
    $amount = $row['incomeAmount'];
    if (!isset($income_data[$category])) {
        $income_data[$category] = $amount;
    } else {
        $income_data[$category] += $amount;
    }
}

// Process expense data
$expense_data = [];
while ($row = $expense_result->fetch_assoc()) {
    $category = $row['expenseCategory'];
    $amount = $row['expenseAmount'];
    if (!isset($expense_data[$category])) {
        $expense_data[$category] = $amount;
    } else {
        $expense_data[$category] += $amount;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses Analysis</title>
    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      
        .container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            flex: 1;
        }
        </style>
</head>
<body>

    <div class="container">
    <h2>Income and Expenses Analysis</h2>
    <div style="width: 50%;">
        <canvas id="incomeExpensesBarChart"></canvas>
    </div>
    <div style="width: 50%;">
        <canvas id="expensesPieChart"></canvas>
    </div>

    <script>
        // Data for income and expenses bar chart
        var incomeData = <?php echo json_encode(array_values($income_data)); ?>;
        var expenseData = <?php echo json_encode(array_values($expense_data)); ?>;
        var categories = <?php echo json_encode(array_keys($income_data)); ?>;

        // Create bar chart
        var ctx = document.getElementById('incomeExpensesBarChart').getContext('2d');
        var incomeExpensesBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Income',
                    data: incomeData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Expenses',
                    data: expenseData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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

        // Data for expenses pie chart
        var expenseCategories = Object.keys(<?php echo json_encode($expense_data); ?>);
        var expenseAmounts = Object.values(<?php echo json_encode($expense_data); ?>);

        // Create pie chart
        var ctx2 = document.getElementById('expensesPieChart').getContext('2d');
        var expensesPieChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: expenseCategories,
                datasets: [{
                    label: 'Expenses',
                    data: expenseAmounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 205, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(201, 203, 207, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
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
    </script>
</body>
</html>
