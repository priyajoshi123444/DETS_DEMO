<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Profile - Expense Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
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
        <h2>Update Your Profile</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <!-- Add your user data fields here -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
            </div>

            <div class="form-group"><label for="gender">Gender</label>
                <div class="gender-radio">
                    <label><input type="radio" name="gender" value="male" required> Male</label>
                    <label><input type="radio" name="gender" value="female" required> Female</label>
                    <label><input type="radio" name="gender" value="other" required> Other</label>
                </div>

                
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" required>
            </div>

            <div class="form-group">
                <label for="profileImage">Profile Image</label>
                <input type="file" class="form-control" name="profileImage" id="profileImage" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <?php
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        // PHP code for handling form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Expense";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get username from session
            $email = $_SESSION["email"]; // Replace 'your_username_key' with the actual key
            $name = $_POST["username"];
            $useremail = $_POST["email"];
            $gender = $_POST["gender"];
            $mobile = $_POST["mobile"];

            // Handle profile image upload
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["profileImage"]["name"]);

            move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile);

            $sql = "UPDATE user SET username='$name', email='$useremail', gender='$gender', mobile_number='$mobile', profile_Image='$targetFile' WHERE email='$email'";

            if ($conn->query($sql) == TRUE) {
                echo "User data updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            // Add validation logic if needed
            return true;
        }
    </script>
</body>

</html>
