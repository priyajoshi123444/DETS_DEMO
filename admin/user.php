<?php
// session_start();
if (!isset($_SESSION)) {
  session_start();
}
// Establish a connection to your database
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

// Fetch user details from the user table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check if there are any users
if ($result->num_rows > 0) {
  // Fetch user details and populate the $users array
  $users = array();
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
} else {
  $users = array(); // If no users found, initialize an empty array
}

// Fetch total expense and total income for each user
foreach ($users as &$user) {
  // Fetch total expense for the user
  $sqlExpense = "SELECT SUM(expenseAmount) AS total_expense FROM expenses WHERE user_id = " . $user['user_id'];
  $resultExpense = $conn->query($sqlExpense);
  $user['total_expense'] = $resultExpense->fetch_assoc()['total_expense'];

  // Fetch total income for the user
  $sqlIncome = "SELECT SUM(incomeAmount) AS total_income FROM incomes WHERE user_id = " . $user['user_id'];
  $resultIncome = $conn->query($sqlIncome);
  $user['total_income'] = $resultIncome->fetch_assoc()['total_income'];
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    .main {
      display: flex;
      padding-top: 70px;
    }

    h2 {
      color: blueviolet;
    }

    th {
      color: blue;
    }

  

    .stretch-card .card .card-body{
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
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">User Details</h4>
          <!-- <p class="card-description"> Add class <code>.table-hover</code>
          </p> -->
          <table class="table table-hover">
            <thead>
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
                <!-- <th>Registration Date</th> -->
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><img src="<?php echo $user['profile_image']; ?>" alt="Profile Image"
                      style="width: 50px; height: 50px;"></td>
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
                    <?php echo $user['total_expense']; ?>
                  </td>
                  <td>
                    <?php echo $user['total_income']; ?>
                  </td>
                  <td>
                    <form method="post" action="update_pricing_status.php">
                      <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                      <input type="hidden" name="pricing_status" id="pricing_status">
                      <button id="active" type="submit" name="pricing_status" value="active">
  <i class="fas fa-check-circle"></i>
</button>
<button id="inactive" type="submit" name="pricing_status" value="inactive" >
  <i class="fas fa-times-circle"></i>
</button>
<button id="pending" type="submit" name="pricing_status" value="pending" >
  <i class="fas fa-question-circle"></i>
</button>

                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
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
    // Get the button elements
    var activeBadge = document.getElementById('active');
    var inactiveButtons = document.getElementById('inactive');
    var pendingButtons = document.getElementById('pending');

    // Add event listeners to the buttons
    document.getElementById('active').addEventListener('click', function () {
      alert('User status updated to Active and Email Sent Sucessfully');
    });


    document.getElementById('inactive').addEventListener('click', function () {
      alert('User status updated to Inactive');
    });

    document.getElementById('pending').addEventListener('click', function () {
      alert('User status updated to Pending');
    });
  </script>
</body>

</html>