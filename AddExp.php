<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expenses - Expenses Management</title>
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

        /* Style for displaying uploaded image */
        .uploaded-image {
            margin-top: 10px;
            max-width: 100%;
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
        <h2>Add Expenses</h2>
        <form>
            <div class="form-group">
                <label for="expenseName">Expense Name</label>
                <input type="text" class="form-control" id="expenseName" placeholder="Enter expense name" required>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Expense Amount</label>
                <input type="number" class="form-control" id="expenseAmount" placeholder="Enter expense amount" required>
            </div>

            <div class="form-group">
                <label for="expenseCategory">Expense Category</label>
                <select class="form-select" id="expenseCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="food">Food</option>
                    <option value="utilities">Utilities</option>
                    <option value="transportation">Transportation</option>
                    <option value="entertainment">Entertainment</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="expenseDescription">Expense Description</label>
                <textarea class="form-control" id="expenseDescription" rows="3" placeholder="Enter expense description"></textarea>
            </div>

            <div class="form-group">
                <label for="expenseDate">Expense Date</label>
                <input type="date" class="form-control" id="expenseDate" required>
            </div>

            <div class="form-group">
                <label for="billImage">Bill Image</label>
                <input type="file" class="form-control" id="billImage">
                <small class="form-text text-muted">Upload a photo of your bill.</small>
            </div>

            <button type="submit" class="btn btn-primary">Add Expense</button>
        </form>

        <!-- Display uploaded image (for demonstration purposes) -->
        <div class="uploaded-image">
            <!-- Placeholder for uploaded image -->
        </div>
    </div>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>