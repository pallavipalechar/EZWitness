<?php
require_once 'database.php';
require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

$email = new PHPMailer\PHPMailer\PHPMailer();

// Set up necessary configuration to send email
$email->IsSMTP();
$email->SMTPAuth = true;
$email->SMTPSecure = 'ssl';
$email->Host = "smtp.gmail.com";
$email->Port = 465;
$email->Username = "wildwhiskerswaffle@gmail.com";
$email->Password = "qzglvjemidadcldm";
$email->SetFrom("wildwhiskerswaffle@gmail.com", "EZWitness System");
$email->Subject = "In-time Report";

#$todayDate = '2024-04-06';
$todayDate = date("Y-m-d");
$emailQuery = "SELECT email FROM emp_details WHERE email IS NOT NULL AND email != ''";
$emailResult = mysqli_query($con, $emailQuery);

if (!$emailResult) {
    die("Email fetch query failed: " . mysqli_error($con));
}

echo "Fetching email addresses and in-time value...<br>";

while ($emailRow = mysqli_fetch_assoc($emailResult)) {
    $employeeEmail = $emailRow['email'];

    echo "Processing email: $employeeEmail...<br>";

    // $inTimeQuery = "SELECT gtime FROM gen_attendance 
    //             WHERE eid IN (SELECT eid FROM emp_details WHERE email = '$employeeEmail') AND gdate = '$todayDate'
    //             ORDER BY gtime ASC
    //             LIMIT 1";
    $inTimeQuery = "SELECT gtime FROM gen_attendance WHERE eid IN (SELECT eid FROM emp_details WHERE email = '$employeeEmail') AND gdate = '$todayDate'
    ORDER BY gtime ASC";
  
    $inTimeResult = mysqli_query($con, $inTimeQuery);

    if (!$inTimeResult) {
        die("In-time fetch query failed: " . mysqli_error($con));
    }

    if ($inTimeRow = mysqli_fetch_assoc($inTimeResult)) {
        $inTime = $inTimeRow['gtime'];

        echo "Fetched in-time: $inTime<br>";

        $email->AddAddress($employeeEmail);
        $email->Body = "Hello! Your in-time was: $inTime.";

        if (!$email->Send()) {
            echo "Error sending email to $employeeEmail: " . $email->ErrorInfo . "<br>";
        } else {
            echo "Email sent successfully to $employeeEmail.<br>";
        }

        mysqli_free_result($inTimeResult);
    } else {
        echo "No in-time found <br>";
    }
}

mysqli_close($con);

echo "Email sending process completed.<br>";
?>