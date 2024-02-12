<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Income Tracker System</title>
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
            <h2>View Income</h2>
            
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
