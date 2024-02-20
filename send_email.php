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

    // Get the logged-in user's email address from the session (assuming you have stored it in the session)
    $user_email = $_SESSION['email']; // Change 'user_email' to the key used to store the user's email address in the session

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
        // Display alert message using JavaScript
        echo '<script>alert("Email sent successfully! Payment is confirmed.");</script>';
        // Redirect to another page
        header('Location: bankdetails.php');
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
}
?>
