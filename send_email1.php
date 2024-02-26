<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Admin email address
    $admin_email = "kagdasakshi09@gmail.com"; // Replace with actual admin email address

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // SMTP server
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username = 'priyajoshi1613@gmail.com';
        $mail->Password = 'yluu rfcn zvdl mtly';                   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);                              // Sender's email address and name
        $mail->addAddress($admin_email);                            // Add a recipient (admin email)

        // Content
        $mail->isHTML(false);                                       // Set email format to plain text
        $mail->Subject = $subject;                                  // Email subject
        $mail->Body    = "Name: $name\nEmail: $email\nPhone Number: $number\nSubject: $subject\nMessage: $message"; // Email body

        // Send email
        $mail->send();
        echo "Your message has been sent successfully!";
        header("Location:index.php");
    } catch (Exception $e) {
        echo "Failed to send your message. Error: {$mail->ErrorInfo}";
    }
}
?>
