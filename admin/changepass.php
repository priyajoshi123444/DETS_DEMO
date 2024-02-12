<?php
session_start(); // Start the session

// Establish a connection to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate that new password matches confirmation password
    if ($newPassword != $confirmPassword) {
        echo "New password and confirm password do not match.";
    } else {
        // Retrieve user ID from session
        if (!isset($_SESSION["user_id"])) {
            echo "User ID not found in session.";
            exit; // Exit script
        }
        $userID = $_SESSION["user_id"];

        // Validate current password against database
        $sql = "SELECT * FROM users WHERE id = '$userID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];

            // Verify the current password using password_verify
            if (password_verify($currentPassword, $hashedPassword)) {
                // Update password in the database
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password
                $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = '$userID'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "Password changed successfully!";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "User not found.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daily Expense Tracker System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="assets/images/logo.png">
                            </div>
                            <h4>Want to Change Password?</h4>
                            <form class="pt-3" action="" method="post">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputOld1"
                                        name="currentPassword" placeholder="Old Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputNew1"
                                        name="newPassword" placeholder="New Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputConfirm1" name="confirmPassword" placeholder="Confirm Password" required>
                                </div>

                                <div class="mt-3 text-center">
                                    <button type="submit"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SAVE</button>
                                    <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                                        href="index.php">BACK</a>
                                </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
</body>

</html>
