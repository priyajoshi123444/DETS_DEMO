<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
            position: relative;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .nav-tabs {
            margin-bottom: 20px;
            position: relative;
        }

        .pdf-icon {
            font-size: 1.5em;
            color: #28a745;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
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
        <h2>View Reports</h2>

        <!-- Tab navigation for expenses and income reports -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="expenses-tab" data-bs-toggle="tab" href="#expenses">Expenses Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="income-tab" data-bs-toggle="tab" href="#income">Income Report</a>
            </li>
            <!-- PDF icon for generating PDF report -->
            <i class="fas fa-file-pdf pdf-icon" onclick="generatePDF()"></i>
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
                        </tr>
                    </thead>
                    <tbody>
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
                        </tr>
                    </thead>
                    <tbody>
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
        <a href="sidebar.php" class="btn btn-primary mt-3">Go Back</a>
    </div>
    </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        function generatePDF() {
            // Create a new jsPDF instance
            var doc = new jsPDF();

            // Add content to the PDF
            doc.text('Expense Report', 10, 10);
            // ... Add more content as needed ...

            // Save the PDF with a specific name
            doc.save('expense_report.pdf');
        }
    </script>
</body>

</html>