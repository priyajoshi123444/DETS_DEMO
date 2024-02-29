<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Budgets - Expenses Management</title>
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
            position: relative; /* Set position to relative */
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

        /* Style for the filter dropdown */
        .filter-form {
            margin-bottom: 20px;
            position: absolute; /* Position the form absolutely */
            top: 20px; /* Adjust top position */
            right: 20px; /* Align to the right */
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

        /* Red color for total expenses exceeding planned amount */
        .over-budget {
            color: red;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>

    <div class="container">
        <h2>View Budgets</h2>

        <!-- Filter for Budgets by Category -->
        <form action="" method="GET" class="filter-form">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category">
                <option value="all">All</option>
                <option value="food">Food</option>
                <option value="housing">Utilities</option>
                <option value="transportation">Transportation</option>
                <!-- Add more options as needed -->
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>

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

        // Fetch budgets for the logged-in user based on category filter
        $category = isset($_GET['category']) ? $_GET['category'] : 'all';

        if ($category == 'all') {
            $sql = "SELECT b.budget_id, b.planned_amount, b.category, b.start_date, b.end_date, 
                    COALESCE(SUM(e.expenseAmount), 0) AS total_expenses
                    FROM budgets b
                    LEFT JOIN expenses e ON b.category = e.expenseCategory
                    WHERE b.user_id = (SELECT user_id FROM users WHERE email = '$email')
                    AND e.user_id = (SELECT user_id FROM users WHERE email = '$email')
                    GROUP BY b.budget_id";
        } else {
            $sql = "SELECT b.budget_id, b.planned_amount, b.category, b.start_date, b.end_date, 
                    COALESCE(SUM(e.expenseAmount), 0) AS total_expenses
                    FROM budgets b
                    LEFT JOIN expenses e ON b.category = e.expenseCategory
                    WHERE b.user_id = (SELECT user_id FROM users WHERE email = '$email') 
                    AND b.category = '$category'
                    AND e.user_id = (SELECT user_id FROM users WHERE email = '$email')
                    GROUP BY b.budget_id";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display budgets table
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Planned Amount</th>
                    <th>Category</th>
                    <th>Total Expenses</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                // Add conditional class based on whether total expenses exceed planned amount
                $totalExpensesClass = ($row['total_expenses'] > $row['planned_amount']) ? 'over-budget' : '';
                echo "<tr>
                        <td>{$row['budget_id']}</td>
                        <td>{$row['planned_amount']}</td>
                        <td>{$row['category']}</td>
                        <td class='{$totalExpensesClass}'>{$row['total_expenses']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>
                            <a href='editbudget.php?id={$row['budget_id']}' class='btn-edit'>Edit</a>
                            <a href='delbudget.php?id={$row['budget_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No budgets found for this user.</p>";
        }

        // Close database connection
        $conn->close();
        ?>

        <a href="AddBudget.php" class="btn btn-primary">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
