<?php
// report.php

session_start();

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Function to establish database connection (customize according to your database credentials)
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Fetch income and expenses for the logged-in user
$conn = connectToDatabase();

// Fetch income
$sqlIncome = "SELECT * FROM income WHERE user_id = (SELECT user_id FROM user WHERE email = '$email')";
$resultIncome = $conn->query($sqlIncome);

// Fetch expenses
$sqlExpense = "SELECT * FROM expense WHERE user_id = (SELECT user_id FROM user WHERE email = '$email')";
$resultExpense = $conn->query($sqlExpense);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses Report - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/istockphoto-1342223620-612x612.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            flex: 1;
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

        h2 {
            color: #007bff;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>Income and Expenses Report</h2>

        <!-- Display Income -->
        <h3>Income</h3>
        <?php if ($resultIncome->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Income Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                <?php while ($row = $resultIncome->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['incomeName']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['incomeDate']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No income found.</p>
        <?php endif; ?>

        <!-- Display Expenses -->
        <h3>Expenses</h3>
        <?php if ($resultExpense->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Expense Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                <?php while ($row = $resultExpense->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['expenseName']; ?></td>
                        <td><?php echo $row['expenseAmount']; ?></td>
                        <td><?php echo $row['expenseDate']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No expenses found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
