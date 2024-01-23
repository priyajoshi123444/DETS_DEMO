<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up - Expenses Management</title>
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

        .signup-container {
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        .signup-container h2 {
            color: #123391;
        }

        .signup-container form {
            margin-top: 20px;
        }

        .signup-container form label {
            font-weight: 600;
        }

        .signup-container form button {
            background-color:#123391;
            color: #ffffff;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .signup-container form button:hover {
            background-color: #0056b3;
        }

        .signup-container .login-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 20px auto;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="container">
            <div class="signup-container">
                <div class="avatar">
                    <img src="assets/images/istockphoto-1393379221-612x612.jpg" alt="User Avatar">
                </div>
                <h2>Sign Up</h2>
                <form>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div class="login-link">
                    Already have an account? <a href="login.html">Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>