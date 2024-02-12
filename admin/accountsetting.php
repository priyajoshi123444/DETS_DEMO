<?php
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    // header("Location: login.php");
    exit();
}

// Include your database connection file
// include('db_connection.php'); // Replace with the actual filename

// Connect to the database (replace these variables with your actual database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expense_db';

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve current user details from the database
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = $user_id"; // Modify the query based on your database schema

$result = $conn->query($sql);

if ($result !== false) {
    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
    } else {
        // Handle the case where user details are not found
        $userDetails = array(); // Empty array if user not found
    }
} else {
    // Handle the case where the SQL query fails
    die("Error: " . $conn->error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the form data (you should add more validation)
    $newName = mysqli_real_escape_string($conn, $_POST['new_name']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['new_email']);

    // Update user details in the database
    $updateSql = "UPDATE users SET username = '$newName', email = '$newEmail' WHERE id = $user_id";
    
    if ($conn->query($updateSql) === true) {
        // Update the userDetails array for display
        $userDetails['username'] = $newName;
        $userDetails['email'] = $newEmail;

        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <style>
        .main {
            display: flex;
            padding-top: 70px;

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
      <!-- plugins:css -->
      <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

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

    <form method="post" action="">
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" value="<?php echo isset($userDetails['username']) ? $userDetails['username'] : ''; ?>" required>

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" value="<?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?>" required>

        <button type="submit">Update Profile</button>
    </form>
        <!-- Bootstrap JS and Popper.js -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>
    <footer>
        <?php
        include("footer.php");
        ?>
    </footer>
</body>

</html>