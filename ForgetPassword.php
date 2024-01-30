<?php
// Include any necessary functions or configurations for email sending here

// Validate the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input (sanitize input if needed)
    $email = $_POST["email"];

    // Add your logic for sending a password reset email here
    // For demonstration purposes, let's assume a simple message
    $reset_message = "An email with instructions to reset your password has been sent to $email.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

        .reset-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="overlay">
        <h2>Forgot Password</h2>
        <?php if (isset($reset_message)): ?>
            <p class="reset-message"><?php echo $reset_message; ?></p>
        <?php else: ?>
            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <button type="submit">Reset Password</button>
            </form>

            <?php
            // Display error messages if any
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
        <?php endif; ?>
    </div>

</body>
</html>