<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
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
            color: blueviolet;
            margin-bottom: 20px;
        }

        .nav-tabs {
            margin-bottom: 20px;
            position: relative;
        }

        .pdf-icon {
            font-size: 1.5em;
            color: red;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .main{
            display: flex;
            padding-top: 70px ;
        }
    </style>
</head>

<body>
    
<header>
        <?php
        include("header.php");
        ?>
    </header>
    <div class="main">
    <sidebar>
    <?php
        include("sidebar.php");
        ?>
    </sidebar>
    <div class="container">
    
        <h2>View Income Reports</h2>

        <!-- Tab navigation for expenses and income reports -->
        <ul class="nav nav-tabs">
          
            <!-- PDF icon for generating PDF report -->
            <i class="fas fa-file-pdf pdf-icon" onclick="generatePDF()"></i>
        </ul>

        <!-- Tab content for expenses and income reports -->
        <div class="tab-content">
            <!-- Expenses Report -->
            <div class="tab-pane fade show active" id="expenses">
                <!-- <h3>Expenses Report</h3> -->
                <?php
            // Database connection details
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'expense_db';
            
            // Create connection
            $conn = new mysqli($host, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // SQL query to fetch users who have added income
            $sql = "SELECT DISTINCT users.id AS user_id, users.username AS username, users.email AS email FROM users INNER JOIN income ON users.id = income.user_id";
            $result = $conn->query($sql);
            
            // Check if any users exist
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    $userId = $row["user_id"];
                    $username = $row["username"];
                    $email = $row["email"];
                    
                    // SQL query to fetch income for the current user
                    $incomeSql = "SELECT * FROM income WHERE user_id = $userId";
                    $incomeResult = $conn->query($incomeSql);
                    
                    // Check if any income exist for the current user
                    if ($incomeResult->num_rows > 0) {
                        echo "<h3>User: $username ($email)</h3>";
                        // Output table for income
                        echo "<table class='table table-bordered table-striped'>"; 
                        echo "<thead class='thead-sucess'>";
                        echo "<tr>";
                        echo "<th>User ID</th>";
                        echo "<th>Income Name</th>";
                        echo "<th>Amount</th>";
                        echo "<th>Category</th>";
                        echo "<th>Description</th>";
                        echo "<th>Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        // Output data of each income
                        while ($incomeRow = $incomeResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $incomeRow["user_id"] . "</td>";
                            echo "<td>" . $incomeRow["incomeName"] . "</td>";
                            echo "<td>" . $incomeRow["incomeAmount"] . "</td>";
                            echo "<td>" . $incomeRow["incomeCategory"] . "</td>";
                            echo "<td>" . $incomeRow["incomeDescription"] . "</td>";
                            echo "<td>" . $incomeRow["incomeDate"] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No income found for user: $username ($email)</p>";
                    }
                }
            } else {
                echo "<p>No users found.</p>";
            }
           
           
            ?>
            

        <!-- Button to go back or perform other actions -->
        <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
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
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>