<?php
require_once("database.php");
$rtype = 'Date';
$report_type = "General";
$tdate = '2024-02-01';
$fdate = '2024-02-01';
$allshift = 'all';

ob_start(); // Start output buffering to capture HTML output

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: ;
        color: ;
    }

    h2.center {
        text-align: center;
    }

    hr {

        display: block;
        unicode-bidi: isolate;
        margin-block-start: 0.5em;
        margin-block-end: 0.5em;
        margin-inline-start: auto;
        margin-inline-end: auto;
        overflow: hidden;
        border-style: inset;
        border-width: 4px;
        webkit-text-decoration-color: black;
        /* Safari */
        text-decoration-color: black;
    }

    span.att {
        font-weight: 600;
        font-size: 18px;
    }

    span.dep {
        font-size: 18px;
        font-weight: 600;
    }

    .split-para {
        display: block;
        margin: 10px;
        font-size: 18px;
    }

    .split-para span {
        display: block;
        float: right;
        width: 19%;
        margin-left: 10px;
    }
</style>

<body onload="printfun()" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="container">
        <?php
        $mainstate = "Basic Report Of Daily Attendance";

        $addf = "'All Shift ' - " . $mainstate;

        ?>
        <h2 class="center"><?php echo $addf; ?></h2>
        <center><span class="date" style="font-size:21px;"> <?php echo "From:&nbsp;" . $fdate . "&nbsp;TO:&nbsp;" . $tdate; ?></span></center>
        <div class="right">

        </div>
        <?php $datt = date("Y-m-d");
        ?>
        <p class="split-para">Company: Default <span>Printed On :<?php echo $datt ?></span></p>
        <hr></hr>

        <?php

        function getBetweenDates($startDate, $endDate)
        {
            $rangArray = [];

            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            for (
                $currentDate = $startDate;
                $currentDate <= $endDate;
                $currentDate += (86400)
            ) {

                $date = date('Y-m-d', $currentDate);
                $rangArray[] = $date;
            }

            return $rangArray;
        }

        $dates = getBetweenDates($fdate, $tdate);

        if ($report_type == "absent" || $report_type == "present" || $report_type == "General") {

            foreach ($dates as $value) {
                $count = "1";

                //echo $search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status, a.shift from attendance a  where Date='".$value."' ";

                $count = "1";
                $scount = "SELECT count(*) FROM attendance WHERE date(`Date`)=date('" . $value . "')";
                $sresult = mysqli_query($con, $scount);
                $srowcount = mysqli_fetch_array($sresult);
                $rocount = $srowcount[0];
                $search = "";
                if ($rocount > 0) {

                    $search = "select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status, a.shift from attendance a  where Date='" . $value . "' UNION
                                    (SELECT eid,fname,concat(dep_description,' (',dep_id,')') `dep_description`,'00:00:00' Date,'' Shift,'00:00:00' In_time,'00:00:00' Out_time,'00:00:00' Work_Hours,'00:00:00' OT,'A' `Status`,'' `shift` FROM `emp_details` WHERE `eid` NOT IN (SELECT Employee_ID FROM attendance WHERE date(`Date`)=date('" . $value . "'))and status='Active')order by Department ";

                    $result = mysqli_query($con, $search);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {

                        echo "</br>";
                        echo "<span class='att'>Attendance Date:</span>" . $value . "</br>";
                        echo "</br>";
                        echo "<span class='dep'>Department:</span>";
                        ?>
                        <table id="customers">
                            <tr>
                                <th>SR NO.</th>
                                <th>Employee_ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Shift</th>
                                <th>In_time</th>
                                <th>Out_time</th>
                                <th>Work_Hours</th>
                                <th>OT</th>
                                <th>Status</th>
                            </tr>

                            <?php
                            $tempdep = '';
                            while ($row = mysqli_fetch_array($result)) {
                                $Department = $row['Department'];

                                if ($Department != $tempdep) {
                                    echo "</table>";
                                    echo "<br>";
                                    echo "Dep Name:" . $Department;
                                    echo "<br>";
                                    echo "<table id='customers'>";
                                    echo "<tr>
                                    <th>SR NO.</th>
                                    <th>Employee_ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>In_time</th>
                                    <th>Out_time</th>
                                    <th>Work_Hours</th>
                                    <th>OT</th>
                                    <th>Status</th>
                                </tr>";
                                }
                                $tempdep = $Department;
                                $Employee_ID = $row['Employee_ID'];
                                $Name = $row['Name'];
                                $Department = $row['Department'];
                                $Date = $row['Date'];
                                $Shift = $row[4];
                                $In_time = $row['In_time'];
                                $Out_time = $row['Out_time'];
                                $Work_Hours = $row['Work_Hours'];
                                $OT = $row['OT'];
                                $Status = $row['Status'];

                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $Employee_ID; ?></td>
                                    <td><?php echo $Name; ?></td>
                                    <td><?php echo $Department; ?></td>
                                    <td><?php echo $Date; ?></td>
                                    <td><?php echo $Shift; ?></td>
                                    <td><?php echo $In_time; ?></td>
                                    <td><?php echo $Out_time; ?></td>
                                    <td><?php echo $Work_Hours; ?></td>
                                    <td><?php echo $OT; ?></td>
                                    <td><?php echo $Status;
                                            $count++; ?></td>
                                </tr>

                            <?php

                            }
                        }
                        ?>
                        </table>
                    <?php
                }
            }
        }

        $htmlContent = ob_get_clean(); // Get the buffered output and clear the buffer

        mysqli_close($con);

        // Email sending code using PHPMailer
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

        // Add recipient address
        $email->AddAddress("nayanohmz@gmail.com");

        // Set email content as HTML
        $email->isHTML(true);
        $email->Subject = "Report for " . date("Y-m-d");
        $email->Body = $htmlContent;

        if (!$email->Send()) {
            echo "Error sending email: " . $email->ErrorInfo . "<br>";
        } else {
            echo "Email sent successfully.<br>";
        }

        ?>
</body>

</html>
