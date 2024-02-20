<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Database connection parameters
$hostname = 'localhost'; // Change this if your database is hosted on a different server
$username = 'root';
$password = '';
$database = 'expense';

// Establish connection to the database
$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    // If connection fails, display an error message and exit
    die("Connection failed: " . mysqli_connect_error());
}

// Get user's subscription details from the database
// Replace this with your actual database query to fetch subscription details for the logged-in user
$user_email = $_SESSION['email'];

// Example subscription data (replace with actual fetched data)
$subscription = array(
    'start_date' => '2024-02-20',
    'end_date' => '2024-03-20',
    'amount_paid' => '50.00', // assuming the currency is in USD
    'status' => 'Active', // you can have statuses like Active, Expired, etc.
    'plan' => 'Premium', // subscription plan name
    'frequency' => 'Monthly', // subscription billing frequency
    'payment_method' => 'By UPI'
);

// Example user data (replace with actual fetched data)
// Let's assume you have a database table named 'users' that stores user details
// Replace 'users' with your actual table name
$query = "SELECT * FROM users WHERE email = '$user_email'";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    // Fetch user data
    $user_data = mysqli_fetch_assoc($result);
    $user_name = $user_data['username']; // Assuming the column for the user's name is 'username'
} else {
    // If query fails, display an error message and exit
    die("Error: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plan Details</title>
    <!-- Add CSS styles -->
    <style>
        /* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('assets/images/istockphoto-1342223620-612x612.jpg'); /* Replace 'background.jpg' with your actual background image path */
    background-size: cover;
    background-position: center;
    color: #333;
    display: flex;
}

.container {
    max-width: 800px;
    margin: auto;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    margin-top: 50px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column; /* Change flex direction to column */
}

.sidebar {
    width: 250px;
    background-color: #111;
    padding-top: 20px;
    color: #818181;
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

.user-details {
    margin-bottom: 20px;
    text-align: center; /* Center align user details */
}

.user-details h3 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.user-details p {
    margin: 5px 0;
    font-size: 16px;
    color: #555;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: #333;
}

th {
    background-color: #f2f2f2;
}

.renew-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Make button width 100% */
    box-sizing: border-box; /* Include padding and border in button width */
}

.renew-button:hover {
    background-color: #45a049;
}

    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar1.php'; ?>

    <div class="container">
        <div class="user-details">
            <!-- <h3>User Details</h3> -->
            <p><strong>Name:</strong> <?php echo $user_name; ?></p>
            <p><strong>Email:</strong> <?php echo $user_email; ?></p>
        </div>
        <h2>Subscription Plan Details</h2>
        <table>
            <tr>
                <th>Start Date</th>
                <td><?php echo $subscription['start_date']; ?></td>
            </tr>
            <tr>
                <th>End Date</th>
                <td><?php echo $subscription['end_date']; ?></td>
            </tr>
            <tr>
                <th>Amount Paid</th>
                <td>$<?php echo $subscription['amount_paid']; ?></td>
            </tr>
            <tr>
                <th>Subscription Plan</th>
                <td><?php echo $subscription['plan']; ?></td>
            </tr>
            <tr>
                <th>Billing Frequency</th>
                <td><?php echo $subscription['frequency']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $subscription['status']; ?></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td><?php echo $subscription['payment_method']; ?></td>
            </tr>
            <tr>
                <th>Renewal</th>
                <td><?php echo ($subscription['status'] === 'Active') ? '<button class="renew-button">Renew Subscription</button>' : 'N/A'; ?></td>
            </tr>
            <!-- Add more subscription details here if needed -->
        </table>
    </div>
</body>

</html>
