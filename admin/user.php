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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">>


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
                  <?php echo isset($user['total_expense']) ? $user['total_expense'] : 0; ?>
                </td>
                <td>
                  <?php echo isset($user['total_income']) ? $user['total_income'] : 0; ?>
                </td>
                <td>
                  <form method="post" action="update_pricing_status.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <input type="hidden" name="pricing_status" id="pricing_status">
                    <i id="active" class="mdi mdi-check-circle mdi-icon" style="cursor: pointer;"
                      onclick="document.getElementById('pricing_status').value = 'active'; this.closest('form').submit();"></i>
                    <i id="inactive" class="mdi mdi-close-circle mdi-icon" style="cursor: pointer;"
                      onclick="document.getElementById('pricing_status').value = 'inactive'; this.closest('form').submit();"></i>
                    <i id="pending" class="mdi mdi-help-circle mdi-icon" style="cursor: pointer;"
                      onclick="document.getElementById('pricing_status').value = 'pending'; this.closest('form').submit();"></i>
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