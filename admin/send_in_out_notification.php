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
$email_body = $config['email_body'];
echo file_get_contents($configPath);

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

    //echo $todayDate = date("Y-m-d");
    $todayDate = '2024-01-13';
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

        $email = new PHPMailer();
        $email->isSMTP();
        $email->SMTPAuth = true;
        $email->SMTPSecure = 'ssl';
        $email->Host = "smtp.gmail.com";
        $email->Port = 465;
        $email->Username = "wildwhiskerswaffle@gmail.com";
        $email->Password = "qzglvjemidadcldm";
        $email->setFrom("wildwhiskerswaffle@gmail.com", $from_name);

        #$emailBody = "Hello $ename! Your face is successfully recognized by EZ Witness Face Recognition System at $inTime on $todayDate";
      	$emailBody = $email_body;
        $email->addAddress($employeeEmail);
        $email->Subject = $email_sub;
        $email->Body = $emailBody;

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

        mysqli_free_result($inTimeResult);
    } else {
        echo "No in-time found for $employeeEmail<br>";
    }

    mysqli_free_result($checkSentResult);
}

mysqli_close($con);

echo "Email sending process completed.<br>";
?>