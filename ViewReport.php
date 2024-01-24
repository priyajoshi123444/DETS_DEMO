<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .nav-tabs {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
        .Form{
            display: flex;
        }
    </style>
</head>

<body>
<div class="Form">

<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>View Reports</h2>

        <!-- Tab navigation for expenses and income reports -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="expenses-tab" data-bs-toggle="tab" href="#expenses">Expenses Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="income-tab" data-bs-toggle="tab" href="#income">Income Report</a>
            </li>
        </ul>

        <!-- Tab content for expenses and income reports -->
        <div class="tab-content">
            <!-- Expenses Report -->
            <div class="tab-pane fade show active" id="expenses">
                <h3>Expenses Report</h3>
                <!-- Table to display expenses report -->
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Description</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example row, replace with dynamic data from your backend -->
                        <tr>
                            <td>2022-03-15</td>
                            <td>$50.00</td>
                            <td>Food</td>
                            <td>Monthly grocery shopping</td>
                        </tr>
                        <!-- Add more rows for each expense entry -->
                    </tbody>
                </table>
            </div>

            <!-- Income Report -->
            <div class="tab-pane fade" id="income">
                <h3>Income Report</h3>
                <!-- Table to display income report -->
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Description</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example row, replace with dynamic data from your backend -->
                        <tr>
                            <td>2022-03-20</td>
                            <td>$200.00</td>
                            <td>Freelance</td>
                            <td>Website development project</td>
                        </tr>
                        <!-- Add more rows for each income entry -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button to go back or perform other actions -->
        <a href="#" class="btn btn-primary mt-3">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>