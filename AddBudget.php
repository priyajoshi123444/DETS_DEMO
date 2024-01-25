<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Budget - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
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
        .add-expenses-container {
            background: url('assets/images/navy-blue-concrete-wall-with-scratches.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
<div class="form-container add-expenses-container">
<div class="Form">

<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Add Budget</h2>
        <form>
            <div class="form-group">
                <label for="budgetName">Budget Name</label>
                <input type="text" class="form-control" id="budgetName" placeholder="Enter budget name" required>
            </div>

            <div class="form-group">
                <label for="budgetAmount">Budget Amount</label>
                <input type="number" class="form-control" id="budgetAmount" placeholder="Enter budget amount" required>
            </div>

            <div class="form-group">
                <label for="budgetStartDate">Start Date</label>
                <input type="date" class="form-control" id="budgetStartDate" required>
            </div>

            <div class="form-group">
                <label for="budgetEndDate">End Date</label>
                <input type="date" class="form-control" id="budgetEndDate" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Budget</button>
        </form>
    </div>
    </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>