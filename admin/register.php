<?php

// Define your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "expense_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
  die("connection failed=" . $conn->connect_error);
}

if (isset($_REQUEST['submit'])) {

  $username = ($_POST["username"]);
  $email = ($_POST["email"]);
  $password = ($_POST["password"]);
  $gender = $_POST["gender"];
  $mobile_number = $_POST["mobile_number"];

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Get the profile image file name
  $profile_image = $_FILES['profile_image']['name'];

  // Move the profile image to the desired location
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
  move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

  // Insert admin data into the database
  $sql = "INSERT INTO admins (username, email, password, profile_image, gender, mobile_number) VALUES ('$username', '$email', '$hashedPassword', '$profile_image', '$gender', '$mobile_number')";

  if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
    header("Location: login.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
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
    function validate() {
      var username = document.getElementById("exampleInputUsername1").value;
      var mobile_number = document.getElementById("exampleInputnumber1").value;
      var profile_image = document.getElementById("exampleInputprofile1");
      var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

      // Validate name
      if (!/^[A-z]{1,100}$/.test(username)) {
        alert("Name should only contain letters and have a maximum length of 100 characters.");
        return false;
      }


      // Validate mobile number
      else if (!/^\d{10}$/.test(mobile_number)) {
        alert("Mobile number should have exactly 10 digits.");
        return false;
      }


      var fileName = profile_image.value;
      var fileExtension = fileName.split('.').pop().toLowerCase();

      // Check if the file extension is allowed
      if (allowedExtensions.indexOf(fileExtension) === -1) {
        alert("Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF.");
        profile_image.value = ""; // Clear the file input
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
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                enctype="multipart/form-data">


                <div class="form-group">
                  <label for="profile_image">Profile Image</label>
                  <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*"
                    required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1"
                    placeholder="Username" name="username" required>
                  <span id="usernameError" class="error"></span>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email"
                    name="email" required>
                  <!-- <label for="exampleInputEmail1" class="form-control form-control-lg">Email -->

                  <!-- </label> -->
                </div>
                <div class="form-group">
                  <label for="exampleInputGender1" class="form-control form-control-lg">Gender</label>
                  <div class="gender-radio">
                    <input type="radio" id="male" name="gender" value="male" required>
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="female" required>
                    <label for="female">Female</label>

                    <input type="radio" id="other" name="gender" value="other" required>
                    <label for="other">Other</label>
                  </div>
                </div>


                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputnumber1"
                    placeholder="Mobile Number" name="mobile_number" required>
                </div>

                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1"
                    placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1"
                    placeholder="Confirm Password" name="confirm_password" required>
                </div>


                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
                  </div>
                </div>

                <div class="mt-3 text-center" name="submit">
                  <button type="submit" name="submit"
                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"><a> SIGN
                      UP</a></button>
                </div>
                <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="login.php"
                    class="text-primary">Login</a>
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