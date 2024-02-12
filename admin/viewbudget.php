<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .main{
            display: flex;
            padding-top: 70px ;
        }
        h2{
            color: blueviolet;
        }
        tr{
            color: blue;
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
    </style>
</head>
<body> 
    <header>
        <?php include("header.php"); ?>
    </header>
    
    <div class="main">
        <sidebar>
            <?php include("sidebar.php"); ?>
        </sidebar>
        <div class="container mt-5">
            <h2>View Budget</h2>
            
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
            
            // SQL query to fetch users who have set budgets
            $sql = "SELECT DISTINCT users.id AS user_id, users.username AS username, users.email AS email FROM users INNER JOIN budget ON users.id = budget.user_id";
            $result = $conn->query($sql);
            
            // Check if any users exist
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    $userId = $row["user_id"];
                    $username = $row["username"];
                    $email = $row["email"];
                    
                    // SQL query to fetch budget for the current user
                    $budgetSql = "SELECT * FROM budget WHERE user_id = $userId";
                    $budgetResult = $conn->query($budgetSql);
                    
                    // Check if any budget exist for the current user
                    if ($budgetResult->num_rows > 0) {
                        echo "<h3>User: $username ($email)</h3>";
                        // Output table for budget
                        echo "<table class='table table-bordered table-striped'>"; 
                        echo "<thead class='thead-sucess'>";
                        echo "<tr>";
                        echo "<th>User ID</th>";
                        echo "<th>Category</th>";
                        echo "<th>Planned Amount</th>";
                        echo "<th>Actual Amount</th>";
                        echo "<th>Start Date</th>";
                        echo "<th>End Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        
                        // Output data of each budget
                        while ($budgetRow = $budgetResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $budgetRow["user_id"] . "</td>";
                            echo "<td>" . $budgetRow["category"] . "</td>";
                            echo "<td>" . $budgetRow["planned_amount"] . "</td>";
                            echo "<td>" . $budgetRow["actual_amount"] . "</td>";
                            echo "<td>" . $budgetRow["start_date"] . "</td>";
                            echo "<td>" . $budgetRow["end_date"] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No budget found for user: $username ($email)</p>";
                    }
                }
            } else {
                echo "<p>No users found.</p>";
            }
           
            // Close connection
            $conn->close();
            ?>
            
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
