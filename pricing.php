<?php
session_start(); // Start the session (if not already started)

// Include database connection
include 'connection.php';

// Check if the user clicked the Activate button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activate'])) {
    // Check if the user is logged in
    if (isset($_SESSION['email'])) {
        // Get user's email
        $email = $_SESSION['email'];

        // Update user's pricing status in the database
        $updateSql = "UPDATE users SET pricing_status = 2 WHERE email = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            // Pricing status updated successfully
            // Redirect user to Bankdetails.php
            header("Location: Bankdetails.php");
            exit(); // Make sure to exit after redirecting
        } else {
            // Error updating pricing status
            echo '<script>alert("Error activating pricing.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: black;
      text-align: left;
      font-size: 16px;
      background: url('assets/images/10061977.jpg') center/cover no-repeat fixed;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      text-align: center;
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.1em;
      margin-bottom: 40px;
    }

    .snip1517 {
      max-width: 800px;
      margin: 0 auto;
      overflow: hidden;
    }

    .snip1517 .plan {
      margin: 0 1%;
      width: 48%;
      padding-top: 10px;
      position: relative;
      float: left;
      overflow: hidden;
      background-color: #ffffff;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .snip1517 .plan:hover i,
    .snip1517 .plan.hover i {
      transform: scale(1.2);
    }

    .snip1517 * {
      box-sizing: border-box;
      transition: all 0.25s ease-out;
    }

    .snip1517 header {
      color: black;
    }

    .snip1517 .plan-title {
      line-height: 60px;
      position: relative;
      margin: 0;
      padding: 0 20px;
      font-size: 1.6em;
      letter-spacing: 2px;
      font-weight: 700;
    }

    .snip1517 .plan-title:after {
      position: absolute;
      content: '';
      top: 100%;
      left: 20px;
      width: 30px;
      height: 3px;
      background-color: #fff;
    }

    .snip1517 .plan-cost {
      padding: 0 20px;
      margin: 0;
    }

    .snip1517 .plan-price {
      font-weight: 400;
      font-size: 2.8em;
      margin: 10px 0;
      display: inline-block;
    }

    .snip1517 .plan-type {
      opacity: 0.8;
      font-size: 0.7em;
      text-transform: uppercase;
    }

    .snip1517 .plan-features {
      padding: 0 0 20px;
      margin: 0;
      list-style: outside none none;
      font-size: 0.9em;
    }

    .snip1517 .plan-features li {
      padding: 8px 20px;
    }

    .snip1517 .plan-features i {
      margin-right: 8px;
      color: rgba(255, 255, 255, 0.5);
    }

    .snip1517 .plan-select {
      border-top: 1px solid rgba(0, 0, 0, 0.2);
      padding: 20px;
      text-align: center;
    }

    .snip1517 .plan-select a {
      background-color: #156dab;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 20px;
      font-size: 0.75em;
      font-weight: 600;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 4px;
      display: inline-block;
    }

    .snip1517 .plan-select a:hover {
      background-color: #1b8ad8 !important;
    }

    .snip1517 .featured {
      margin-top: -10px;
      z-index: 1;
      border-radius: 8px;
      border: 2px solid #ffffff;
      background-color:#ffffff;
    }

    .snip1517 .featured .plan-select {
      padding: 30px 20px;
    }

    .snip1517 .featured .plan-select a {
      background-color: #10507e;
    }

    /* Hidden by default */
    #paymentDetails {
      display: none;
      position: fixed;
      z-index: 1;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #ccc;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
    }

    /* Close button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Our Pricing Plans</h1>
    <p>Choose the plan that suits you best.</p>
  </div>
  <div class="snip1517">
    <div class="plan">
      <header>
        <h4 class="plan-title">
          Basic Plan
        </h4>
        <div class="plan-cost"><span class="plan-price">Free</span><span class="plan-type"></span></div>
      </header>
      <ul class="plan-features">
        <li><i class="ion-android-remove"> </i>Keep track of your daily expenses</li>
        <li><i class="ion-android-remove"> </i>Here,Get started for free</li>
        <li><i class="ion-android-remove"> </i>Access basic budgeting tools and expense tracking</li>
        <li><i class="ion-android-remove"> </i>Enjoy free features like manage income , expense ,etc</li>
        <li><i class="ion-android-remove"> </i>Start your journey with our Free Basic Plan</li>
      </ul>
      <div class="plan-select"><a href="#">It's Free</a></div>
    </div>
    
    <div class="plan featured">
      <header>
        <h4 class="plan-title">
          Premium Plan
        </h4>
        <div class="plan-cost"><span class="plan-price">₹100</span><span class="plan-type">/month</span></div>
      </header>
   
      <ul class="plan-features">
        <li><i class="ion-android-remove"> </i>Upgrade to Premium Plan Today</li>
        <li><i class="ion-android-remove"> </i>Unlock premium features</li>
        <li><i class="ion-android-remove"> </i>Gain access to PDF report generation</li>
        <li><i class="ion-android-remove"> </i>Enjoy expense tracking with our Premium Plan.</li>
        <li><i class="ion-android-remove"> </i>Elevate your expenses with our Premium Plan</li>
      </ul>
      <!-- PHP code to check authentication and display appropriate content -->
      <?php
     // Placeholder for user authentication status
     $email = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Check if user is logged in
     echo '<!-- Debug: Email: ' . $email . ' -->'; // Add this line for debugging
     
     if ($email) {
         // If user is logged in, display the activation button with pop-up menu
         echo '<div class="plan-select">';
         echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
         echo '<input type="hidden" name="activate">';
         echo '<button type="submit">Activate</button>';
         echo '</form>';
         echo '</div>';
     } else {
         // If user is not logged in, disable the activation button
         echo '<div class="plan-select"><button disabled>Activate</button></div>';
     }
    ?>
  </div>

  <!-- Payment Details Pop-up Menu -->
  <div id="paymentDetails">
    <span class="close" onclick="closePaymentDetails()">&times;</span>
    <h2>Payment Details</h2>
    <!-- Placeholder for payment details -->
    <p>Bank Name: [Bank Name]</p>
    <p>Account Number: [Account Number]</p>
    <!-- Add more payment details here -->
    <button onclick="confirmPayment()">Confirm Payment</button>
  </div>


  <script>
    // JavaScript functions
    function showPaymentDetails() {
      var paymentDetails = document.getElementById("paymentDetails");
      paymentDetails.style.display = "block";
    }

    function closePaymentDetails() {
      var paymentDetails = document.getElementById("paymentDetails");
      paymentDetails.style.display = "none";
    }

    function confirmPayment() {
      alert("Payment confirmed!"); // Placeholder for demonstration
    }
  </script>
</body>
</html>
