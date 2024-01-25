<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
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
        .Form{
            display: flex;
        }
        .add-expenses-container {
            background: url('assets/images/navy-blue-concrete-wall-with-scratches.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
<div class="form-container add-expenses-container">
<div class="Form">

<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Change Password</h2>

        <!-- Change password form -->
        <form>
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label for="confirmNewPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmNewPassword" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>

        <!-- Button to go back or perform other actions -->
        <a href="sidebar.php" class="btn btn-primary mt-3">Go Back</a>
    </div>
    </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>