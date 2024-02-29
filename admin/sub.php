<?php
session_start(); // Start the session

// Include the database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "expense_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page or display an error message
    // header("Location: login.php");
    // exit(); // Stop further execution
}

// Retrieve the admin's current details from the database
$admin_id = $_SESSION['id'];
$selectQuery = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Retrieve subscription details from the database
$selectSubQuery = "SELECT * FROM subscription";
$stmtSub = $conn->prepare($selectSubQuery);
$stmtSub->execute();
$resultSub = $stmtSub->get_result();
$subscriptions = $resultSub->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Expense Tracker System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .main {
      display: flex;
      padding-top: 70px;
    }
    h2{
            color: blueviolet;
        }
        th{
          color: blue;
        }
    /* .container {
      max-width: 800px;
      margin: 50px auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative;
    } */
    .active{
      background-color: green;

    }
    .inactive{
      background-color: red;
    }
    .pending{
      background-color: yellow;
    }
  </style>
</head>

<body>
  <header>
    <?php include("header.php"); ?>
  </header>

  <div class="main">
    <sidebar>
      <?php include("sidebar.php"); ?>
    </sidebar>
    <div class="container mt-5">
      <h2>Subscription Details</h2>
      <div class="table-responsive">
      <table class="table">
        <tr>
            <th>Subscription ID</th>
            <th>User ID</th>
            <th>Subscription Plan</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Billing Frequency</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
           
        </tr>
        <?php foreach ($subscriptions as $subscription) : ?>
            <tr>
                <td><?php echo $subscription['subscription_id']; ?></td>
                <td><?php echo $subscription['user_id']; ?></td>
                <td><?php echo $subscription['subscription_plan']; ?></td>
                <td><?php echo $subscription['start_date']; ?></td>
                <td><?php echo $subscription['end_date']; ?></td>
                <td><?php echo $subscription['billing_frequency']; ?></td>
                <td><?php echo $subscription['amount']; ?></td>
                <td><?php echo $subscription['payment_method']; ?></td>
                <td><?php echo $subscription['status']; ?></td>
                <td>
                  <!-- <form action="update_subscription_status.php" method="post">
                    <input type="hidden" name="subscription_id" value="<?php echo $subscription['subscription_id']; ?>">
                    <select name="status">
                      <option value="active">Active</option>
                      <option value="inactive">Inactive</option>
                      <option value="pending">Pending</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                  </form> -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>

</html>
