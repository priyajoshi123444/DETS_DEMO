<?php
// Start the session
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Check if the confirm_payment button was clicked
if (isset($_POST['confirm_payment'])) {
    // Admin's email address
    $admin_email = 'kagdasakshi09@gmail.com';

    // Get the logged-in user's email address from the session
    $user_email = $_SESSION['email']; // Change 'email' to the key used to store the user's email address in the session

    // Get the payment method selected by the user
    $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 'Unknown';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'priyajoshi1613@gmail.com';
        $mail->Password = 'yluu rfcn zvdl mtly';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        //Recipients
        $mail->setFrom($user_email); // Set the sender's email address
        $mail->addAddress($admin_email); // Add the admin's email address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Payment Confirmation';
        // Constructing the email body
        $mail->Body = '<p>Dear Admin,</p>';
        $mail->Body .= '<p>I am writing to inform you that the payment has been confirmed by a user. Here are the details:</p>';
        $mail->Body .= '<ul>';
        $mail->Body .= '<li>User Email: ' . $user_email . '</li>';
        // You can add more details if needed
        $mail->Body .= '</ul>';
        $mail->Body .= '<p>Please take necessary actions accordingly.</p>';
        $mail->Body .= '<p>Best regards,<br>User</p>';

        // Send the email
        $mail->send();
        
        // Database connection
        include 'connection.php'; // Include your database connection file

        // Fetch user ID and pricing status based on email from the database
        $sql = "SELECT user_id, pricing_status FROM users WHERE email = '$user_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $pricing_status = $row['pricing_status'];

            // Calculate start and end date
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+1 year', strtotime($startDate)));

            // Other subscription details (assumed constants)
            $subscriptionPlan = 'Premium';
            $billingFrequency = 'Yearly';
            $amount = 500;

            // Determine status based on pricing status
            $status = $pricing_status == 1 ? 'Active' : 'Pending';

            // Insert into database
            $sql = "INSERT INTO subscription (user_id, start_date, end_date, payment_method, subscription_plan, billing_frequency, amount, status) 
                    VALUES ('$user_id', '$startDate', '$endDate', '$paymentMethod', '$subscriptionPlan', '$billingFrequency', $amount, '$status')";

            // Execute SQL query
            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Email sent successfully! Payment is confirmed. Subscription information added to the database.");</script>';
                // Redirect to another page
                header('Location: bankdetails.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "User not found";
        }

    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
}
?>
