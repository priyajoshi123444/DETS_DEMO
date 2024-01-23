<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/istockphoto-1393379221-612x612.jpg') center/cover no-repeat fixed;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.7);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .forgot-password-container {
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        .forgot-password-container h2 {
            color:#123391;
        }

        .forgot-password-container p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .forgot-password-container form {
            margin-top: 20px;
        }

        .forgot-password-container form label {
            font-weight: 600;
        }

        .forgot-password-container form button {
            background-color:#123391;
            color: #ffffff;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .forgot-password-container form button:hover {
            background-color: #0056b3;
        }

        .forgot-password-container .login-link {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="forgot-password-container">
            <h2>Forgot Password</h2>
            <p>Enter your email address and we'll send you instructions on how to reset your password.</p>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <button type="submit">Reset Password</button>
            </form>
            <div class="login-link">
                <a href="Login.php">Back to Login</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
