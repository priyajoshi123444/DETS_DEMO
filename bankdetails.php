<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bank Details</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: black;
      text-align: center;
      font-size: 16px;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.1em;
      margin-bottom: 20px;
    }

    .bank-details {
      text-align: left;
      margin-bottom: 20px;
    }

    .bank-details p {
      margin: 5px 0;
    }

    .confirm-button {
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
      cursor: pointer;
    }

    .confirm-button:hover {
      background-color: #1b8ad8;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Payment Details</h1>
    <div class="bank-details">
      <p><strong>Bank Name:</strong> XYZ Bank</p>
      <p><strong>Account Number:</strong> XXXXXXXX</p>
      <p><strong>IFSC Code:</strong> XXXX1234</p>
      <!-- Add more details as needed -->
    </div>
    <form method="post" action="send_email.php">
    <button class="confirm-button" type="submit"onclick="return paymentConfirmed()">Confirm Payment</button> 
    <input type="hidden" name="confirm_payment">
</form>
  </div>
  <script>
    // Function to display an alert after the payment is confirmed
    function paymentConfirmed() {
      alert("Payment confirmed! Email sent successfully.");
    }
  </script>
</body>
</html>
