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

// Define the specific date for which you want to test the in-time (in 'YYYY-MM-DD' format)
$specificDate = '2024-04-06'; // Change this to your desired date

// Fetch email addresses from the emp_details table
$emailQuery = "SELECT email FROM emp_details WHERE email IS NOT NULL AND email != ''";
$emailResult = mysqli_query($con, $emailQuery);

if (!$emailResult) {
    die("Email fetch query failed: " . mysqli_error($con));
}

echo "Fetching email addresses and in-time values for $specificDate...<br>";

// Loop through each employee's email address
while ($emailRow = mysqli_fetch_assoc($emailResult)) {
    $employeeEmail = $emailRow['email'];

    // Debug message
    echo "Processing email: $employeeEmail...<br>";

    // Fetch in-time for the specific date from the attendance table
    $inTimeQuery = "SELECT gtime FROM gen_attendance 
                    WHERE employee_id IN (SELECT employee_id FROM emp_details WHERE email = '$employeeEmail') 
                    AND DATE(In_time) = '$specificDate'";
  
    $inTimeResult = mysqli_query($con, $inTimeQuery);

    if (!$inTimeResult) {
        die("In-time fetch query failed: " . mysqli_error($con));
    }

    // Fetch in-time value from the result set
    if ($inTimeRow = mysqli_fetch_assoc($inTimeResult)) {
        $inTime = $inTimeRow['In_time'];

        // Debug message
        echo "Fetched in-time: $inTime<br>";

        // Set email content with in-time information for the specific date
        $email->AddAddress($employeeEmail);
        $email->Body = "Hello! Your in-time on $specificDate was: $inTime.";

        // Send the email
        if (!$email->Send()) {
            echo "Error sending email to $employeeEmail: " . $email->ErrorInfo . "<br>";
        } else {
            echo "Email sent successfully to $employeeEmail.<br>";
        }

        // Clear the in-time result set
        mysqli_free_result($inTimeResult);
    } else {
        // Debug message for no in-time found
        echo "No in-time found for $specificDate<br>";
    }
}

// Close the database connection
mysqli_close($con);

echo "Email sending process completed.<br>";
?>