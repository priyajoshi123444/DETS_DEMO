<?php

include('connection.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: SingUp.php"); // Redirect to login page if not logged in
    exit();
} 

// Fetch user information from the database
$email = $_SESSION['email'];
$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle error if user not found
    echo "User not found";
}

// Close the database connection after all necessary queries


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="_sidebar.scss">
  <link rel="stylesheet" href="materialdesignicons.min.css">
  <link rel="stylesheet" href="vendor.bundle.base.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/fonts/materialdesignicons-webfont.eot">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="favicon.ico" />

</head>

<body>
  
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <!-- Use the user's profile image if available, otherwise use a default image -->
                    <?php if (!empty($user['profile_image'])) : ?>
                        <img src="<?php echo $user['profile_image']; ?>" alt="profile">
                    <?php else : ?>
                        <img src="assets/images/default_profile.jpg" alt="profile">
                    <?php endif; ?>
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?php echo $user['username']; ?></span>
                    <span class="text-secondary text-small"><?php echo $user['email']; ?></span>
                </div>
                <span class="mdi mdi-bookmark-check text-success nav-profile-badge"></span>
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
        <div class="collapse show" id="ui-basic">
          <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="AddExp.php">Add Expense</a></li>
            <li class="nav-item"> <a class="nav-link" href="ViewExp.php">View Expense</a></li>
            
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
          <li class="nav-item"> <a class="nav-link" href="AddIncome.php">Add Income</a></li>
            <li class="nav-item"> <a class="nav-link" href="ViewIncome.php">View Income</a></li>
            
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
          <li class="nav-item"> <a class="nav-link" href="AddBudget.php">Add Budget</a></li>
            <li class="nav-item"> <a class="nav-link" href="viewbudget.php">View Budget</a></li>
            
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
            <li class="nav-item"> <a class="nav-link" href="AddCategory.php">Add Category</a></li>
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
            <li class="nav-item"> <a class="nav-link" href="ViewReport.php">View Report</a></li>

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
            <li class="nav-item"> <a class="nav-link" href="MyprofileSetting.php">My Profile</a></li>
            <li class="nav-item"> <a class="nav-link" href="ChangePswd.php">Change Password</a></li>
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
  <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="Chart.min.js"></script>
    <script src="jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="off-canvas.js"></script>
    <script src="hoverable-collapse.js"></script>
    <script src="misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="dashboard.js"></script>
    <script src="todolist.js"></script>
    <!-- End custom js for this page -->
</body>
</html>