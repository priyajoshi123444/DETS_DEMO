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

$sql = "SELECT 
            COUNT(*) AS total_users,
            SUM(CASE WHEN pricing_status = 1 THEN 1 ELSE 0 END) AS subscribed_users,
            SUM(CASE WHEN pricing_status = 0 THEN 1 ELSE 0 END) AS free_users
        FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $total_users = $row["total_users"];
    $subscribed_users = $row["subscribed_users"];
    $free_users = $row["free_users"];
  }
} else {
  $total_users = 0;
  $subscribed_users = 0;
  $free_users = 0;
}

$admin_id = $_SESSION['id'];
$selectQuery = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();


$selectSubQuery = "SELECT s.*, u.username FROM subscription s JOIN users u ON s.user_id = u.user_id";
$stmtSub = $conn->prepare($selectSubQuery);
$stmtSub->execute();
$resultSub = $stmtSub->get_result();
$subscriptions = $resultSub->fetch_all(MYSQLI_ASSOC);

foreach ($subscriptions as $subscription) {
  $expiryDate = strtotime($subscription['end_date']);
  $threeDaysBeforeExpiry = strtotime('-3 days', $expiryDate);
  $currentDate = time();

  if ($currentDate >= $threeDaysBeforeExpiry && $currentDate < $expiryDate) {

    $to = $subscription['email'];
    $subject = "Renew Your Subscription";
    $message = "Dear " . $subscription['username'] . ",\n\nYour subscription is expiring soon. Please renew your subscription to continue using our service.\n\nThank you.";
    $headers = "From: kagdasakshi09@gmail.com";

    mail($to, $subject, $message, $headers);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    .stretch-card .card {
      width: 20%;
      min-width: 68%;
    }
    .thead{
      background-color: #b66dff;
    }
    th {
      color: white;
    }
  </style>
</head>

<body>

  <?php


  include("header.php");

  ?>


  <div class="container-fluid page-body-wrapper">

    <?php
    include('sidebar.php');
    ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
        </div>
        <div class="row">
          <?php
          echo "<div class='col-md-4 stretch-card grid-margin'>";
          echo "<div class='card bg-gradient-danger card-img-holder text-white'>";
          echo "<div class='card-body'>";
          echo "<img src='assets/images/dashboard/circle.svg' class='card-img-absolute' alt='circle-image'>";
          echo "<h4 class='font-weight-normal mb-3'>Total Users <i class='mdi mdi-account-circle mdi-24px float-right'></i></h4>";
          echo "<h2 class='mb-5'>" . $total_users . "</h2>";
          echo "<h6 class='card-text'>Increased by 20%</h6>";
          echo "</div>";
          echo "</div>";
          echo "</div>";

          echo "<div class='col-md-4 stretch-card grid-margin'>";
          echo "<div class='card bg-gradient-info card-img-holder text-white'>";
          echo "<div class='card-body'>";
          echo "<img src='assets/images/dashboard/circle.svg' class='card-img-absolute' alt='circle-image'>";
          echo "<h4 class='font-weight-normal mb-3'>Total Subscribe users <i class='mdi mdi-account-check mdi-24px float-right'></i></h4>";
          echo "<h2 class='mb-5'>" . $subscribed_users . "</h2>";
          echo "<h6 class='card-text'>Decreased by 10%</h6>";
          echo "</div>";
          echo "</div>";
          echo "</div>";

          echo "<div class='col-md-4 stretch-card grid-margin'>";
          echo "<div class='card bg-gradient-success card-img-holder text-white'>";
          echo "<div class='card-body'>";
          echo "<img src='assets/images/dashboard/circle.svg' class='card-img-absolute' alt='circle-image'>";
          echo "<h4 class='font-weight-normal mb-3'>Free Users <i class='mdi mdi-account-minus mdi-24px float-right'></i></h4>";
          echo "<h2 class='mb-5'>" . $free_users . "</h2>";
          echo "<h6 class='card-text'>Decreased by 15%</h6>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          ?>
        </div>
        <div class="row">
          <div class="col grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">User Status</h4>
                <div class="table">
                  <table class="table table-striped ">
                     <thead class="thead">
                    <tr>
                      <th>User Id</th>
                      <th>Subscription ID</th>
                      <th> Username </th>
                      <th> Start Date</th>
                      <th> End Date </th>
                      <th>Total Expense</th>
                      <th>Total Income</th>
                      <th>Renew</th>
                    </tr>
                    </thead>
                    <?php foreach ($subscriptions as $subscription): ?>
                      <tr>
                        <td>
                          <?php echo $subscription['user_id']; ?>
                        </td>
                        <td>
                          <?php echo $subscription['subscription_id']; ?>
                        </td>
                        <td>
                          <?php echo $subscription['username']; ?>
                        </td>
                        <td>
                          <?php echo $subscription['start_date']; ?>
                        </td>
                        <td>
                          <?php echo $subscription['end_date']; ?>
                        </td>
                        <td>
                          <?php
                          // Fetch total expense for the user
                          $sqlExpense = "SELECT SUM(expenseAmount) AS total_expense FROM expenses WHERE user_id = " . $subscription['user_id'];
                          $resultExpense = $conn->query($sqlExpense);
                          $totalExpense = $resultExpense->fetch_assoc()['total_expense'];
                          echo $totalExpense !== null ? $totalExpense : 0;
                          ;
                          ?>
                        </td>
                        <td>
                          <?php
                          // Fetch total income for the user
                          $sqlIncome = "SELECT SUM(incomeAmount) AS total_income FROM incomes WHERE user_id = " . $subscription['user_id'];
                          $resultIncome = $conn->query($sqlIncome);
                          $totalIncome = $resultIncome->fetch_assoc()['total_income'];
                          echo $totalIncome !== null ? $totalIncome : 0;
                          ;
                          ?>
                        </td>
                        <td>
                          <form action="reminder.php" method="get">
                            <input type="hidden" name="subscription_id"
                              value="<?php echo $subscription['subscription_id']; ?>">
                            <button type="submit" class="btn btn-primary">Renew</button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="clearfix">
                    <h4 class="card-title float-left">User Statistics</h4>
                    <div id="user-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right">
                    </div>
                  </div>
                  <canvas id="user-chart" class="mt-4"></canvas>
                </div>
              </div>
            </div>
          </div>
          <script>
            var ctx = document.getElementById('user-chart').getContext('2d');
            var userChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ['Registered Users', 'Subscribed Users', 'Non-Subscribed Users'],
                datasets: [{
                  label: 'Number of Users',
                  data: [<?php echo $total_users; ?>, <?php echo $subscribed_users; ?>, <?php echo $free_users; ?>],
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                  ],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                }
              }
            });
          </script>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- content-wrapper ends -->
  <!-- partial:partials/_footer.html -->
  <?php
  include('footer.php');
  ?>
  <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
</body>

</html>