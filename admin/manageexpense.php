<?php
// Establish a connection to your database
$servername = "localhost";
$username = "root";
$password = "";
$database = "expense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch income and expense data from your database
$sql = "SELECT * FROM incomes";
$result = $conn->query($sql);

// Initialize arrays to store income and expense data
$incomeData = array();
$expenseData = array();

// Loop through the results and populate the arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incomeData[] = $row['incomeAmount'];
    }
}

// Fetch expense data from your database
$sql = "SELECT * FROM expenses";
$result = $conn->query($sql);

// Loop through the results and populate the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenseData[] = $row['expenseAmount'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .main {
            display: flex;
            padding-top: 70px;
        }

        h2 {
            color: blueviolet;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        canvas {
            max-width: 100%;
            height: auto;
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
        <h2>Income VS Expense</h2>
        <canvas id="myChart"></canvas>
        <script>
            // Prepare data for Chart.js
            var data = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Income",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1,
                        data: <?php echo json_encode($incomeData); ?>
                    },
                    {
                        label: "Expense",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1,
                        data: <?php echo json_encode($expenseData); ?>
                    }
                ]
            };

            // Create a new chart
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
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
