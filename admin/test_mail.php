<?php
require_once 'database.php'; // Assuming this file contains your database connection details
require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

// Load configuration from EZWitness_config.properties
$configPath = '/opt/lampp/htdocs/ez/python/fr_allconfig/ipconfig_file.properties';

$config = parse_ini_file($configPath);
var_dump($config);
$config = parse_ini_file($configPath);
if ($config === false) {
    die('Error loading configuration file. Path: ' . $configPath);
}
if (file_exists($configPath)) {
    echo "The file $configPath exists.";
    if (is_readable($configPath)) {
        echo "The file $configPath is readable.";
    } else {
        echo "The file $configPath is not readable.";
    }
} else {
    echo "The file $configPath does not exist.";
}
// Check if required keys exist in the config array
$requiredKeys = ['from_name', 'email_sub', 'email_body'];
foreach ($requiredKeys as $key) {
    if (!array_key_exists($key, $config)) {
        die("Missing key '$key' in configuration file.");
    }
}

// Assign config values to variables
$from_name = $config['from_name'];
$email_sub = $config['email_sub'];
$email_body = $config['email_body'];

// Sample data for testing
$employeeEmail = 'nayanohmz@gmail.com'; // Change this to the actual email address you want to send to
$ename = 'John Doe'; // Employee name for personalization
$inTime = '12:00 PM'; // Example in-time for the email
$todayDate = date('Y-m-d'); // Current date

// Prepare the email body using placeholders for dynamic data
$emailBody = str_replace(
    ['$ename', '$inTime', '$todayDate'],
    [$ename, $inTime, $todayDate],
    $email_body
);

// Initialize PHPMailer
$email = new PHPMailer();
$email->isSMTP();
$email->SMTPAuth = true;
$email->SMTPSecure = 'ssl';
$email->Host = "smtp.gmail.com";
$email->Port = 465;
$email->Username = "wildwhiskerswaffle@gmail.com"; // Your email username
$email->Password = "qzglvjemidadcldm"; // Your email password
$email->setFrom("wildwhiskerswaffle@gmail.com", $from_name);

$email->addAddress($employeeEmail);
$email->Subject = $email_sub;
$email->Body = $emailBody;

// Send the email
if (!empty($emailBody) && $email->send()) {
    echo "Email sent successfully to $employeeEmail.";
} else {
    echo "Error sending email to $employeeEmail: " . $email->ErrorInfo;
}
?>