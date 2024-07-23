<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/PHPMailer.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); // Show errors on the screen

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $fullName = isset($_POST['fname']) ? $_POST['fname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $attachmentPath = 'Demo Items/data.txt'; // Get path to attachment from the form

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                            // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'pretentraven@gmail.com';                 // SMTP username
        $mail->Password = 'pvfeqchvrmcuvelj';                     // SMTP password (use App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                        // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $fullName);
        $mail->addAddress("pretentraven@gmail.com", $fullName); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = "Name: $fullName<br>Email: $email<br>Message: $message";
        $mail->AltBody = "Name: $fullName\nEmail: $email\nMessage: $message";

        // Add the attachment
        if (file_exists($attachmentPath)) {
            $mail->addAttachment($attachmentPath);
        } else {
            throw new Exception('Attachment file not found.');
        }

        $mail->send();
        // Redirect to thank you page using JavaScript
        echo '<script>window.location.href = "thank_you.html";</script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
