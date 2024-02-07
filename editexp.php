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

// Check if expense ID is provided in the URL
if (isset($_GET["id"])) {
    $expenseId = $_GET["id"];

    // Fetch expense details from the database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM expense WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $expenseId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $expense = $result->fetch_assoc();
            } else {
                echo "Expense not found.";
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
    echo "Expense ID not provided.";
    exit();
}

// Check if the form is submitted for updating the expense
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $expenseId = $_POST["expenseId"];
    $expenseName = $_POST["expenseName"];
    $expenseAmount = $_POST["expenseAmount"];
    $expenseCategory = $_POST["expenseCategory"];
    $expenseDescription = $_POST["expenseDescription"];
    $expenseDate = $_POST["expenseDate"];
    $billImage = isset($_FILES["billImage"]) ? $_FILES["billImage"]["name"] : $expense["billImage"]; // Use existing value if file is not uploaded

    $sql = "UPDATE expense SET
            expenseName = ?,
            expenseAmount = ?,
            expenseCategory = ?,
            expenseDescription = ?,
            expenseDate = ?,
            billImage = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssi", $expenseName, $expenseAmount, $expenseCategory, $expenseDescription, $expenseDate, $billImage, $expenseId);

        if ($stmt->execute()) {
            echo "Expense updated successfully.";
        } else {
            echo "Error updating expense: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Handle file upload
    if (!empty($_FILES["billImage"]["tmp_name"])) {
        $targetDir = "uploads/"; // Specify the directory where you want to store uploaded files
        $targetFile = $targetDir . basename($_FILES["billImage"]["name"]);

        move_uploaded_file($_FILES["billImage"]["tmp_name"], $targetFile);
        echo "File uploaded successfully.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense - Expenses Management</title>
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
        <h2>Edit Expense</h2>
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
            <input type="hidden" name="expenseId" value="<?php echo $expense["id"]; ?>">

            <!-- Your form fields for updating expense details -->
            <div class="form-group">
                <label for="expenseName">Expense Name</label>
                <input type="text" class="form-control" name="expenseName" id="expenseName" value="<?php echo $expense["expenseName"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Expense Amount</label>
                <input type="number" class="form-control" name="expenseAmount" id="expenseAmount" value="<?php echo $expense["expenseAmount"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="expenseCategory">Expense Category</label>
                <select class="form-select" name="expenseCategory" id="expenseCategory" required>
                    <option value="food" <?php echo ($expense["expenseCategory"] === "food") ? "selected" : ""; ?>>Food</option>
                    <option value="utilities" <?php echo ($expense["expenseCategory"] === "utilities") ? "selected" : ""; ?>>Utilities</option>
                    <option value="transportation" <?php echo ($expense["expenseCategory"] === "transportation") ? "selected" : ""; ?>>Transportation</option>
                    <option value="entertainment" <?php echo ($expense["expenseCategory"] === "entertainment") ? "selected" : ""; ?>>Entertainment</option>
                </select>
            </div>

            <div class="form-group">
                <label for="expenseDescription">Expense Description</label>
                <textarea class="form-control" name="expenseDescription" id="expenseDescription" rows="3" placeholder="Enter expense description"><?php echo $expense["expenseDescription"]; ?></textarea>
            </div>

            <div class="form-group">
                <label for="expenseDate">Expense Date</label>
                <input type="date" class="form-control" name="expenseDate" id="expenseDate" value="<?php echo $expense["expenseDate"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="billImage">Bill Image</label>
                <input type="file" class="form-control" name="billImage" id="billImage">
                <small class="form-text text-muted">Upload a new photo of your bill or leave it blank to keep the existing one.</small>
            </div>

            <!-- Your submit button -->
            <button type="submit" class="btn btn-primary">Update Expense</button>
        </form>

        <?php
        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // (This part has been moved to the top of the file for clarity)
        }
        ?>

        <script>
            function validateForm() {
                var expenseName = document.getElementById('expenseName').value;
                var expenseAmount = document.getElementById('expenseAmount').value;
                var expenseCategory = document.getElementById('expenseCategory').value;
                var expenseDate = document.getElementById('expenseDate').value;

                if (expenseName.trim() === '' || expenseAmount.trim() === '' || expenseCategory.trim() === '' || expenseDate.trim() === '') {
                    alert('Please fill in all required fields.');
                    return false;
                }

                return true;
            }
        </script>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>