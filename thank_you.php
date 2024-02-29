<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You for Subscription</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: #333;
      text-align: center;
      font-size: 16px;
      margin: 0;
      padding: 0;
      background-image: url('assets/images/10061977.jpg');
      background-size: cover;
      background-position: center;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 40px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      font-size: 3em;
      margin-bottom: 20px;
      color: #007bff;
    }

    p {
      font-size: 1.2em;
      margin-bottom: 20px;
      color: #555;
    }

    .features-container {
      display: flex;
      justify-content: space-between;
      width: 100%;
      margin-top: 30px;
    }

    .feature {
      flex: 1;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 8px;
      margin-right: 20px;
      text-align: left;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .feature:last-child {
      margin-right: 0;
    }

    .feature h2 {
      color: #007bff;
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .feature p {
      color: #555;
      font-size: 1.1em;
    }

    .btn-go-use {
      background-color: #28a745;
      color: #ffffff;
      text-decoration: none;
      padding: 15px 30px;
      font-size: 1em;
      font-weight: 600;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 2px;
      display: inline-block;
      cursor: pointer;
      border: none;
      transition: background-color 0.3s ease;
      margin-top: 30px;
    }

    .btn-go-use:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Thank You for Subscribing!</h1>
    <p>Welcome to our premium subscription service. You are now a valued member, and we are thrilled to have you on board.</p>
    <div class="features-container">
      <div class="feature">
        <h2>Report PDF Generator</h2>
        <p>Generate detailed PDF reports with ease to keep track of your activities and progress.</p>
      </div>
      <div class="feature">
        <h2>Notification</h2>
        <p>Stay updated with real-time notifications about important events and announcements.</p>
      </div>
      <div class="feature">
        <h2>Add Bill Image</h2>
        <p>Attach bill images to your transactions for better record-keeping and organization.</p>
      </div>
    </div>
    <a href="demo.php" class="btn-go-use">Get Instant Access Now!</a>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
