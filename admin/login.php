<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    // header("Location: login.php");
    // exit();
}

// Continue with the rest of your code here



// Define your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "expense_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Sanitize user input
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Retrieve hashed password from the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Store user_id in session
            $_SESSION['id'] = $row['id'];
            // Redirect to the dashboard or another page
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect email or password";
        }
    } else {
        echo "User not found";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Budget Buddy</title>
  <script>
        function validateForm() {
            var email = document.getElementById("exampleInputEmail1").value;
            var password = document.getElementById("exampleInputPassword1").value;
            var errorMessage = document.getElementById("error-message");

            // Basic validation
            if (email === "" || password === "") {
               alert("Email and password are required.");
                return false;
            }
           
return true;
}
           
           
        
    </script>
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

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="assets/images/logo.png">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1"
                    placeholder="Password"  name="password">
                </div>
                <!-- <div class="mt-3 text-center" name="submit">
                  <button type="submit"  name="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" ><a > SIGN </a></button>
                </div> -->
                <div class="mt-3 text-center">
   <button type="submit" name="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"><a > SIGN IN</a></button>
</div>

                <div class="my-2 d-flex justify-content-between align-items-center">

                  <a href="forgotpass.php" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.php"
                    class="text-primary">Create</a>
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
