<?php
// Start output buffering to prevent output from being sent prematurely
ob_start();

// Start the session
session_start();

// Your remaining PHP code goes here
// ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Income - Income Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/reading-glasses-personal-planning-finances.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
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
            flex-direction: column;
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
            background-color:#007bff;
            text-decoration: none;
            padding: 5px 10px;
            margin-right: 5px;
            color: white;
            transition: background-color 0.3s;
        }


        .btn-edit:hover,
        .btn-delete:hover {
            background-color: #007bff;
            color: #fff;
        }

        /* Style for the filter dropdown */
        .filter-form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .filter-form label {
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        .filter-form button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        /* Adjust date column */
        .date-column {
            white-space: nowrap; /* Prevent line break */
        }

        /* Adjust action buttons */
        .action-buttons {
            display: flex;
            align-items: center;
        }

        /* Add margin between action buttons */
        .action-buttons a {
            margin-right: 5px;
        }

        /* Style for the "Go Back" button */
        .container .btn-primary {
            margin-top: 10px; /* Add margin to separate from the table */
            width: fit-content; /* Adjust button width to fit content */
            padding: 5px 10px; /* Adjust padding */
            font-size: 16px; /* Decrease font size */
            background-color: #007bff; /* Change background color */
            border-color: #007bff; /* Change border color */
            color: #fff; /* Change text color */
        }
        .btn-primary:hover {
            background-color: #0056b3 !important;
        }

        /* Adjust table wrapper */
        .table-wrapper {
            height: 500px; /* Set height to 500px */
            width: 100%; /* Set width to 100% */
            overflow-y: auto; /* Add vertical scrollbar */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>View Expenses</h2>

        <!-- Filter Form -->
        <form action="" method="GET" class="filter-form">
            <label for="month">Filter by Month:</label>
            <select name="month" id="month">
                <option value="all">All Months</option>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>

        <!-- Income Table -->
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
            header("Location: login.php");
            exit();
        }

        // Get the logged-in user's email from the session
        $email = $_SESSION['email'];

        // Fetch income for the logged-in user based on filter selection
        $month = isset($_GET['month']) ? $_GET['month'] : 'all';

        $sql = "SELECT * FROM expenses WHERE user_id = (SELECT user_id FROM users WHERE email = '$email')";

        if ($month !== 'all') {
            $sql .= " AND MONTH(expenseDate) = $month";
        }
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display income table
            echo "<div class='table-wrapper'>";
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['expense_id']}</td>
                        <td>{$row['expenseName']}</td>
                        <td>{$row['expenseAmount']}</td>
                        <td>{$row['expenseCategory']}</td>
                        <td>{$row['expenseDescription']}</td>
                        <td>{$row['expenseDate']}</td>
                        <td>
                            <a href='editexp.php?id={$row['expense_id']}' class='btn-edit'>Edit</a>
                            <a href='delete_expense.php?id={$row['expense_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No expense found for this user.</p>";
        }

        // Close database connection
        $conn->close();
        ?>

        <a href="AddExp.php" class="btn btn-primary">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
