<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/man-using-calculator-concept-budget-business-finance_220873-13988.avif') center/cover no-repeat fixed;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            text-align: center;
        }

        .login-container h2 {
            color:#123391;
        }

        .login-container form {
            margin-top: 20px;
        }

        .login-container form label {
            color:#123391;
            font-weight: 600;
        }

        .login-container form button {
            background-color:#123391;
            color: #ffffff;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container form button:hover {
            background-color: #0056b3;
        }
        .login-container .text-center {
            color:#123391;
        }

        .login-container .forgot-password {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="container">
            <div class="login-container">
                
                <h2>Login</h2>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <form action="Login.php" method="post">
        <button type="button" onclick="redirectToSidebar()">Login</button>
                   
                    <script>
        function redirectToSidebar() {
            window.location.href = "sidebar.php";
        }
    </script>
                </form>
                </form>
                <div class="forgot-password">
                    <a href="ForgetPassword.php">Forgot Password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="SingUp.php" class="text-primary">Create</a>
                  </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>