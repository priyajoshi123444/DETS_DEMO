<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - Expenses & Income Management</title>
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

        .btn-edit,
        .btn-delete {
            text-decoration: none;
            padding: 5px 10px;
            margin-right: 5px;
            border: 1px solid #007bff;
            color: #007bff;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .btn-edit:hover,
        .btn-delete:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pdf-symbol {
            font-size: 24px;
            color: #007bff;
            margin-right: 10px;
        }

        /* Styling for expenses */
        .expense {
            color: red;
        }

        /* Styling for income */
        .income {
            color: green;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>Combined Expenses and Income Report</h2>

        <?php 
        // Start session to access session variables
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        // Include database connection
        include  'connection.php';

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            // Redirect to login page or display an error message
            header("Location: login.php");
            exit();
        }

        // Get the logged-in user's email from the session
        $email = $_SESSION['email'];

        // Fetch expenses and income for the logged-in user
        $sql = "SELECT expense_id, expenseName AS Name, expenseAmount AS Amount, expenseCategory AS Category, expenseDescription AS Description, expenseDate AS Date, billImage AS Image, 'Expense' AS Type FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') UNION ALL SELECT income_id, incomeName AS Name, incomeAmount AS Amount, incomeCategory AS Category, incomeDescription AS Description, incomeDate AS Date, NULL AS Image, 'Income' AS Type FROM incomes WHERE user_id = (SELECT user_id FROM users WHERE email = '$email') ORDER BY Date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display combined report
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Type</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                // Add specific class based on type (expense or income)
                $typeClass = ($row['Type'] === 'Expense') ? 'expense' : 'income';
                echo "<tr class='$typeClass'>
                        <td>{$row['expense_id']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Amount']}</td>
                        <td>{$row['Category']}</td>
                        <td>{$row['Description']}</td>
                        <td>{$row['Date']}</td>
                        <td>{$row['Image']}</td>
                        <td>{$row['Type']}</td>
                    </tr>";
            }
            echo "</table>";

            // PDF download link for combined report
            echo "<a href='download_combined_report.php' class='btn btn-primary'><span class='pdf-symbol'>&#x1F4C4;</span>Download Combined Report (PDF)</a>";
        } else {
            echo "<p>No data found for this user.</p>";
        }

        ?>

        <a href="sidebar1.php" class="btn btn-primary">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
