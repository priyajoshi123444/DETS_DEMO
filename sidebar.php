
<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
// include('database.php'); // Replace with the actual filename

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

// Retrieve user details from the database
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = $user_id"; // Modify the query based on your database schema

$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
} else {
    // Handle the case where user details are not found
    $userDetails = array(); // Empty array if user not found
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Expense Tracker System</title>
  <link rel="stylesheet" href="assets/scss/_sidebar.scss">
  <link rel="stylesheet" href="assets/css/style.css">

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
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
      <div class="nav-profile-image">
        <?php
        // Check if the 'image' column exists and is not empty
        if (isset($userDetails['profile_image']) && !empty($userDetails['profile_image'])) {
            echo '<img src="' . $userDetails['profile_image'] . '" alt="profile">';
        } else {
            // Display a default image if the 'image' column is empty or not found
            echo '<img src="assets/images/default-profile-image.jpg" alt="default-profile">';
        }
        ?>
        <span class="login-status online"></span>
        <!--change to offline or busy as needed-->
    </div>
    <div class="nav-profile-text d-flex flex-column">
        <span class="font-weight-bold mb-2"><?php echo isset($userDetails['username']) ? $userDetails['username'] : ''; ?></span>
        <span class="text-secondary text-small"><?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?></span>
    </div>
    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Expense</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-cash-multiple menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="addexpense.php">Add Expense</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewexpense.php">Manage Expense</a></li>
          </ul>
        </div>

      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-1" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Income</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-cash menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-1">
          <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="addincome.php">Add Income</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewincome.php">Manage Income</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-2" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Budget</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-briefcase  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-2">
          <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="addbudget.php">Add Budget</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewbudget.php">Manage Budget</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-3" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Category</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-checkerboard  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-3">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="addcategory.php">Add Category</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-4" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Report</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-file-document menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-4">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="viewreport.php">View Report</a></li>

          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-5" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
          <i class=" mdi mdi-account-settings  menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic-5">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="accountsetting.php">My Profile</a></li>
            <li class="nav-item"> <a class="nav-link" href="changepass.php">Change Password</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <span class="menu-title">Logout</span>
          <i class="mdi mdi-logout menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>

</body>

</html>
