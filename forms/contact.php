<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Replace contact@example.com with your real receiving email address
    $receiving_email_address = 'wanmohddanialhakim@gmail.com';

    // Define the correct path to the PHP Email Form library
    $php_email_form = 'assets/vendor/php-email-form/php-email-form.php';

    // Check if the library file exists
    if (file_exists($php_email_form)) {
        echo "Library file found.<br>";
        include($php_email_form);
        echo "Library file included successfully.<br>";
    } else {
        die('Unable to load the "PHP Email Form" Library! Path checked: ' . $php_email_form);
    }

    // Check if the class exists
    if (class_exists('PHP_Email_Form')) {
        echo "Class PHP_Email_Form exists.<br>";
        // Create a new instance of the PHP_Email_Form class
        $contact = new PHP_Email_Form;
        $contact->ajax = true;

        // Set form properties
        $contact->to = $receiving_email_address;
        $contact->from_name = $_POST['name'];
        $contact->from_email = $_POST['email'];
        $contact->subject = $_POST['subject'];

        // Configure SMTP settings
        $contact->smtp = array(
          'host' => 'smtp.gmail.com', // Change this to your SMTP server address
          'username' => 'wanmohddanialhakim@gmail.com',
          'password' => 'DektoFred@3',
          'port' => 587, // Change this to your SMTP port
          'encryption' => 'tls' // or 'ssl'
      );
      
        // Add messages from the form fields
        $contact->add_message($_POST['name'], 'From');
        $contact->add_message($_POST['email'], 'Email');
        $contact->add_message($_POST['message'], 'Message', 10);

        // Send the email and output the result
        $result = $contact->send();
        echo $result;
    } else {
        die('Class PHP_Email_Form not found.');
    }
} else {
    // Handle non-POST requests
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
