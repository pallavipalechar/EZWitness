<?php
require_once 'database.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$configPath = '/opt/lampp/htdocs/ez/python/fr_allconfig/mail_content.txt';
$config = parse_ini_file($configPath);

$from_name = $config['from_name'];
$email_sub = $config['email_sub'];
$email_body_template = $config['email_body'];  // Load the template from the file

// Debugging output
echo "Loaded email body template: $email_body_template<br>";

$email = new PHPMailer();
$email->isSMTP();
$email->SMTPAuth = true;
$email->SMTPSecure = 'ssl';
$email->Host = "smtp.gmail.com";
$email->Port = 465;
$email->Username = "wildwhiskerswaffle@gmail.com";
$email->Password = "qzglvjemidadcldm";
$email->setFrom("wildwhiskerswaffle@gmail.com", $from_name);
$email->Subject = $email_sub;

$emailQuery = "SELECT email, eid, fname FROM emp_details WHERE email IS NOT NULL AND email != ''";
$emailResult = mysqli_query($con, $emailQuery);

if (!$emailResult) {
    die("Email fetch query failed: " . mysqli_error($con));
}

echo "Fetching email addresses and in-time value...<br>";

while ($emailRow = mysqli_fetch_assoc($emailResult)) {
    $employeeEmail = $emailRow['email'];
    $employeeID = $emailRow['eid'];
    $ename = $emailRow['fname'];

    echo "Processing email: $employeeEmail...<br>";

    $checkSentQuery = "SELECT intime_email_sent, last_gtime_sent FROM gen_attendance WHERE eid = '$employeeID'";
    $checkSentResult = mysqli_query($con, $checkSentQuery);

    if (!$checkSentResult) {
        die("Error checking email sent status: " . mysqli_error($con));
    }

    $checkSentRow = mysqli_fetch_assoc($checkSentResult);
    $intimeEmailSent = $checkSentRow['intime_email_sent'];
    $lastGTimeSent = $checkSentRow['last_gtime_sent'];

    $todayDate = '2024-05-14';  // Use a fixed date for debugging; replace with dynamic date in production
    $inTimeQuery = "SELECT gtime FROM gen_attendance 
                    WHERE eid = '$employeeID' AND gdate = '$todayDate'
                    ORDER BY gtime DESC
                    LIMIT 1";

    echo "Executing in-time query: $inTimeQuery<br>";

    $inTimeResult = mysqli_query($con, $inTimeQuery);

    if (!$inTimeResult) {
        die("In-time fetch query failed: " . mysqli_error($con));
    }

    if ($inTimeRow = mysqli_fetch_assoc($inTimeResult)) {
        $inTime = $inTimeRow['gtime'];
        echo "Fetched in-time: $inTime<br>";

        if ($intimeEmailSent == 1 && $lastGTimeSent == $inTime) {
            echo "Email already sent with the same in-time. Skipping...<br>";
            continue; // Skip sending 
        }

        // Debugging output
        echo "Name: $ename, In-Time: $inTime, Today Date: $todayDate<br>";

        // Prepare email body with dynamic content
        $emailBody = str_replace(['$inTime', '$ename', '$todayDate'], [$inTime, $ename, $todayDate], $email_body_template);
        $email->addAddress($employeeEmail);
        $email->Body = $emailBody;

        // Debugging output
        echo "Email body: $emailBody<br>";

        if (!empty($emailBody) && $email->send()) {
            echo "Email sent successfully to $employeeEmail.<br>";

            $updateSentQuery = "UPDATE gen_attendance SET intime_email_sent = 1, last_gtime_sent = '$inTime' WHERE eid = '$employeeID'";
            $updateSentResult = mysqli_query($con, $updateSentQuery);

            if (!$updateSentResult) {
                echo "Error updating email sent status: " . mysqli_error($con) . "<br>";
            }
        } else {
            echo "Error sending email to $employeeEmail: " . $email->ErrorInfo . "<br>";
        }

        $email->clearAddresses(); // Clear the recipient for the next iteration
    } else {
        echo "No in-time found for $employeeEmail<br>";
    }

    mysqli_free_result($checkSentResult);
    mysqli_free_result($inTimeResult);
}

mysqli_free_result($emailResult);
mysqli_close($con);

echo "Email sending process completed.<br>";
?>
