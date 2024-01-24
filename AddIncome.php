<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income - Expenses Management</title>
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
    </style>
</head>

<body>
<div class="Form">

<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Add Income</h2>
        <form>
            <div class="form-group">
                <label for="incomeAmount">Earning Amount</label>
                <input type="number" class="form-control" id="incomeAmount" placeholder="Enter earning amount" required>
            </div>

            <div class="form-group">
                <label for="incomeCategory">Income Category</label>
                <select class="form-select" id="incomeCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="salary">Salary</option>
                    <option value="freelance">Freelance</option>
                    <option value="investment">Investment</option>
                    <option value="other">Other</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="incomeDescription">Income Description</label>
                <textarea class="form-control" id="incomeDescription" rows="3" placeholder="Enter income description"></textarea>
            </div>

            <div class="form-group">
                <label for="incomeDate">Income Date</label>
                <input type="date" class="form-control" id="incomeDate" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Income</button>
        </form>
    </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>