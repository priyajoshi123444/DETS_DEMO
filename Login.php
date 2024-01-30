<?php
session_start();

// Validate the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input (sanitize input if needed)
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Add your database connection code here
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "Expense";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SELECT query to get user information
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($dbUsername, $dbPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the entered password with the stored hashed password
    if ($dbUsername && password_verify($password, $dbPassword)) {
        // Set session variable upon successful login
        $_SESSION["username"] = $username;

        // Redirect to the dashboard or another page
        header("Location: sidebar.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('assets/images/10061977.jpg') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #555;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .links {
            text-align: center;
            margin-top: 10px;
        }

        .links a {
            color: #333;
            text-decoration: underline;
            margin: 0 10px;
            cursor: pointer;
        }

        .links a:hover {
            color: #555;
        }
    </style>
</head>
<body>

    <div class="overlay">
        <h2>Login</h2>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>

        <?php
        // Display error messages if any
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <div class="links">
            <a href="ForgetPassword.php">Forgot Password?</a>
            <span>|</span>
            <a href="SingUp.php">Create Account</a>
        </div>
    </div>

</body>
</html>