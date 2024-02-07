<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Expenses - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/istockphoto-1342223620-612x612.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;l
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
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="container">
        <h2>View Expenses</h2>

        <?php if(!isset($_SESSION)) { session_start(); } ?>

        <?php if (isset($_SESSION['email'])): ?>
            <?php
            $email = $_SESSION['email'];
            $conn = mysqli_connect("localhost", "root", "", "Expense") or die("connection failed");
            $sql = "SELECT * FROM expenses WHERE user_id = '$email'";
            $result = $conn->query($sql);
            ?>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['expenseName']; ?></td>
                            <td><?php echo $row['expenseAmount']; ?></td>
                            <td><?php echo $row['expenseCategory']; ?></td>
                            <td><?php echo $row['expenseDescription']; ?></td>
                            <td><?php echo $row['expenseDate']; ?></td>
                            <td><?php echo $row['billImage']; ?></td>
                            <td>
                                <a href='edit_expense.php?id=<?php echo $row['id']; ?>' class='btn-edit'>Edit</a>
                                <a href='delete_expense.php?id=<?php echo $row['id']; ?>' class='btn-delete' onclick='return confirm("Are you sure you want to delete this record?");'>Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No expenses found.</p>
            <?php endif; ?>

        <?php endif; ?>

        <a href="sidebar.php" class="btn btn-primary">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
