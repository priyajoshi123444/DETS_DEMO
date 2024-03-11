<?php
// Ensure session is started
if (!isset($_SESSION)) {
  session_start();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "expense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch user details from the users table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Initialize an empty array for users
$users = array();

// Check if there are any users
if ($result->num_rows > 0) {
  // Fetch user details and populate the $users array
  while ($row = $result->fetch_assoc()) {
    $user = $row;
    // Fetch total expense for the user
    $sqlExpense = "SELECT SUM(expenseAmount) AS total_expense FROM expenses WHERE user_id = " . $user['user_id'];
    $resultExpense = $conn->query($sqlExpense);
    $user['total_expense'] = $resultExpense->fetch_assoc()['total_expense'];

    // Fetch total income for the user
    $sqlIncome = "SELECT SUM(incomeAmount) AS total_income FROM incomes WHERE user_id = " . $user['user_id'];
    $resultIncome = $conn->query($sqlIncome);
    $user['total_income'] = $resultIncome->fetch_assoc()['total_income'];

    // Add user details to the $users array
    $users[] = $user;
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Expense Tracker System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
  <style>
    .main {
      display: flex;
      padding-top: 70px;
    }

    h2 {
      color: black;
    }

    .stretch-card .card .card-body {
      width: 68%;
      min-width: 65%;
    }

    .card-title {
      margin-bottom: 20px;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .table th {
      background-color: #f8f9fa;
    }

    .table th,
    .table td {
      border: 1px solid #dee2e6;
    }

    .table th,
    .table td {
      padding: 12px;
    }

    .table th {
      font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .table tbody tr:hover {
      background-color: #e2e2e2;
    }

    .table img {
      max-width: 50px;
      max-height: 50px;
      border-radius: 50%;
    }

    .badge {
      border: none;
      width: 70px;
      height: 39px;
      cursor: pointer;
    }

    .badge:hover {
      opacity: 0.8;
    }

    /* Optional: Add a hover effect to the buttons */
    .badge:hover {
      background-color: #007bff;
      color: white;
    }

    .badge {
      border: none;
      width: 70px;
      height: 39px;

    }

    tr {
      color: black;
    }

    .thead {
      background-color: #b66dff;

    }

    th {
      color: white;
    }

    .pagination .page-item .page-link {
      color: black;
    }

    .mdi-icon {
      font-size: 24px;

      margin-right: 10px;
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
    <div class="content-wrapper">
    <div class="container mt-5">
      <h2> User Details</h2>
      <div class="table-wrapper" style="height: 1000px; width: 980px; overflow-y:auto" ;>
        <table class=" table table-bordered table-hover">
          <thead class="thead">
            <tr>
              <th>Profile Image</th>
              <th>Username</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Mobile Number</th>
              <th>Current Status</th>
              <th>Total Expense</th>
              <th>Total Income</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td>
                  <img
                    src="<?php echo isset($user['profile_image']) && file_exists($user['profile_image']) ? $user['profile_image'] : 'assets/images/faces/face1.jpg'; ?>"
                    alt="Profile Image" style="width: 50px; height: 50px;">
                </td>
                <td>
                  <?php echo $user['username']; ?>
                </td>
                <td>
                  <?php echo $user['email']; ?>
                </td>
                <td>
                  <?php echo $user['gender']; ?>
                </td>
                <td>
                  <?php echo $user['mobile_number']; ?>
                </td>
                <td>
                  <?php
                  if ($user['pricing_status'] == 0) {
                    echo "Inactive";
                  } else if ($user['pricing_status'] == 1) {
                    echo "Active";
                  } else if ($user['pricing_status'] == 2) {
                    echo "Pending";
                  }
                  ?>
                </td>
                <td>
                  <?php echo isset($user['total_expense']) ? $user['total_expense'] : 0; ?>
                </td>
                <td>
                  <?php echo isset($user['total_income']) ? $user['total_income'] : 0; ?>
                </td>
                <td>
                  <form method="post" action="update_pricing_status.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <input type="hidden" name="pricing_status" id="pricing_status_<?php echo $user['user_id']; ?>">
                    <i class="mdi mdi-check-circle mdi-icon" style="cursor: pointer;"
                      onclick="updateStatus('active', <?php echo $user['user_id']; ?>)"></i>
                    <i class="mdi mdi-close-circle mdi-icon" style="cursor: pointer;"
                      onclick="updateStatus('inactive', <?php echo $user['user_id']; ?>)"></i>
                    <i class="mdi mdi-help-circle mdi-icon" style="cursor: pointer;"
                      onclick="updateStatus('pending', <?php echo $user['user_id']; ?>)"></i>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
        <!-- Button to go back or perform other actions -->
        <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
      </div>
    </div>
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
  <script>
    function updateStatus(status, userId) {
      document.getElementById('pricing_status_' + userId).value = status;
      document.getElementById('pricing_status_' + userId).closest('form').submit();
      alert('User status updated to ' + status + ' for user ID ' + userId);
    }
  </script>

</body>

</html>