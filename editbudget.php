<?php
session_start();

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Function to establish database connection (customize according to your database credentials)
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Check if budget ID is provided in the URL
if (isset($_GET["id"])) {
    $budgetId = $_GET["id"];

    // Fetch budget details from the database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM budget WHERE budget_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $budgetId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $budget = $result->fetch_assoc();
            } else {
                echo "Budget not found.";
                exit();
            }
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
            exit();
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $conn->close();
} else {
    echo "Budget ID not provided.";
    exit();
}

// Check if the form is submitted for updating the budget
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $budgetId = $_POST["budgetId"];
    $budgetName = $_POST["budgetName"];
    $actualamount = $_POST["actual_amount"];
    $plannedamount = $_POST["planned_amount"];
    $category = $_POST["category"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];


    $sql = "UPDATE budget SET
        budget_name = ?,
        actual_amount = ?,
        planned_amount = ?,
        category = ?,
        start_date = ?,
        end_date = ?
        WHERE budget_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssissi", $budgetName, $actualamount, $plannedamount, $category, $startDate, $endDate, $budgetId);


        if ($stmt->execute()) {
            echo "Budget updated successfully.";
        } else {
            echo "Error updating budget: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/istockphoto-1342223620-612x612.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
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
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include 'sidebar1.php'; ?>
    </div>
    <div class="container">
        <h2>Edit Budget</h2>
        <form method="post" action="" onsubmit="return validateForm()">
            <input type="hidden" name="budgetId" value="<?php echo $budget["budget_id"]; ?>">

            <!-- Your form fields for updating budget details -->
            <div class="form-group">
                <label for="budgetName">Budget Name</label>
                <input type="text" class="form-control" name="budgetName" id="budgetName" value="<?php echo $budget["budget_name"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="actualamount">Actual Amount</label>
                <input type="number" class="form-control" name="actual_amount" id="actualamount" placeholder="Enter budget amount" required>
            </div>

            <div class="form-group">
    <label for="plannedAmount">Planned Amount</label>
    <input type="number" class="form-control" name="planned_amount" id="plannedAmount" placeholder="Enter planned amount" required>
</div>

            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-select" name="category" id="category" required>
    <option value="food" <?php echo ($budget["category"] === "food") ? "selected" : ""; ?>>Food</option>
    <option value="utilities" <?php echo ($budget["category"] === "utilities") ? "selected" : ""; ?>>Utilities</option>
    <option value="transportation" <?php echo ($budget["category"] === "transportation") ? "selected" : ""; ?>>Transportation</option>
    <option value="entertainment" <?php echo ($budget["category"] === "entertainment") ? "selected" : ""; ?>>Entertainment</option>
</select>

            </div>

            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" name="startDate" id="startDate" value="<?php echo $budget["start_date"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" name="endDate" id="endDate" value="<?php echo $budget["end_date"]; ?>" required>
            </div>

            <!-- Your submit button -->
            <button type="submit" class="btn btn-primary">Update Budget</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // (This part has been moved to the top of the file for clarity)
        }
        ?>

<script>
            function validateForm() {
                var budgetName = document.getElementById('budgetName').value;
               var actualamount = document.getElementById('actual_amount').value;
               var planedamount = document.getElementById('planned_amount').value;
                var category = document.getElementById('category').value;
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;

                if (budgetName.trim() === '' || actualamount.trim() === '' || planedamount.trim() ==='' || category.trim() === '' || startDate.trim() === '' || endDate.trim() === '') {
                    alert('Please fill in all required fields.');
                    return false;
                }

                return true;
            }
        </script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
