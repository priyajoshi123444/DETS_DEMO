<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "Expense") or die("connection failed");

    $email = $_SESSION['email'];

    // Fetch user ID based on email
    $select_query = "SELECT user_id FROM user WHERE email='$email'";
    $result_user = mysqli_query($conn, $select_query);
    $user_data = mysqli_fetch_assoc($result_user);
    $user_id = $user_data['user_id'];

    // Fetch income records for the logged-in user using their user_id
    $sql = "SELECT * FROM income WHERE id = $user_id";
    $result = $conn->query($sql);
?>
   <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>View Income - Income Management</title>
        <!-- Bootstrap CSS -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background: url('assets/images/istockphoto-1342223620-612x612.jpg') no-repeat center center fixed;
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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table, th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            .btn-edit,
            .btn-delete {
                text-decoration: none;
                padding: 5px 10px;
                margin-right: 5px;
                border: 1px solid #007bff;
                color: #007bff;
                border-radius: 3px;
                transition: background-color 0.3s;
            }

            .btn-edit:hover,
            .btn-delete:hover {
                background-color: #007bff;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class='sidebar'>
            <?php include 'sidebar.php'; ?>
        </div>
        <div class='container'>
            <h2>View Income</h2>
            

            <?php if ($result->num_rows > 0) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Income Name</th>
                        <th>Income Amount</th>
                        <th>Income Category</th>
                        <th>Income Description</th>
                        <th>Income Date</th>
                        <th>Action</th>
                    </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['incomeName']; ?></td>
                        <td><?php echo $row['incomeAmount']; ?></td>
                        <td><?php echo $row['incomeCategory']; ?></td>
                        <td><?php echo $row['incomeDescription']; ?></td>
                        <td><?php echo $row['incomeDate']; ?></td>
                        <td>
                            <a href='edit_income.php?id=<?php echo $row['id']; ?>' class='btn-edit'>Edit</a>
                            <a href='delete_income.php?id=<?php echo $row['id']; ?>' class='btn-delete' onclick='return confirm("Are you sure you want to delete this record?");'>Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            <?php } else {
                echo "No income records found.";
            } ?>
         <a href="sidebar.php" class="btn btn-secondary btn-go-back">Go Back</a>
    </div>

        <!-- Bootstrap JS and Popper.js -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>
<?php } else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>
