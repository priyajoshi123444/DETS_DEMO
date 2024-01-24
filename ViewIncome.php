<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Income - Expenses Management</title>
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
            color: #28a745;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
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
            background-color: #28a745;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger,
        .btn-warning {
            border: none;
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
        <h2>View Income</h2>

        <!-- Table to display income -->
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>Earning Name</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Example row, replace with dynamic data from your backend -->
                <tr>
                    <td>Freelance Work</td>
                    <td>$200.00</td>
                    <td>Freelance</td>
                    <td>Website development project</td>
                    <td>2022-03-20</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Update</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                <!-- Add more rows for each income entry -->
            </tbody>
        </table>

        <!-- Button to go back or perform other actions -->
        <a href="#" class="btn btn-success mt-3">Go Back</a>
    </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>