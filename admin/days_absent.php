<?php
require_once("database.php");

$employee_id = $_GET['emp_id'];
if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    echo "Error: Month not set.";
    exit;
}

$shift_details = array();

$shift_times_sql = "
SELECT 
    shift_name, 
    shift_start_time 
FROM 
    shift_details
";

$shift_times_result = $con->query($shift_times_sql);

while ($row = $shift_times_result->fetch_assoc()) {
    $shift_details[$row['shift_name']] = $row['shift_start_time'];
}

$shift1_name = '';
$shift1_intime = '';
$shift2_name = '';
$shift2_intime = '';
$shift3_name = '';
$shift3_intime = '';

$shift_keys = array_keys($shift_details);
if (isset($shift_keys[0])) {
    $shift1_name = $shift_keys[0];
    $shift1_intime = $shift_details[$shift1_name];
}
if (isset($shift_keys[1])) {
    $shift2_name = $shift_keys[1];
    $shift2_intime = $shift_details[$shift2_name];
}
if (isset($shift_keys[2])) {
    $shift3_name = $shift_keys[2];
    $shift3_intime = $shift_details[$shift3_name];
}
// Query for days absent
$absent_sql = "
SELECT 
    Employee_ID,
    Name,
    Date
FROM 
    attendance 
WHERE 
    Employee_ID = '$employee_id'
    AND DATE_FORMAT(Date, '%Y-%m') = '$month'
    AND Status = 'A' 
";
$absent_result = $con->query($absent_sql);

// Query for late check-ins
$late_checkin_sql = "
SELECT 
    Employee_ID,
    Name,
    Date,
    In_time
FROM 
    attendance 
WHERE 
    Employee_ID = '$employee_id'
    AND ((Shift = '$shift1_name' AND TIME_TO_SEC(TIMEDIFF(In_time, '$shift1_intime')) > 300) 
         OR (Shift = '$shift2_name' AND TIME_TO_SEC(TIMEDIFF(In_time, '$shift2_intime')) > 300)
         OR (Shift = '$shift3_name' AND TIME_TO_SEC(TIMEDIFF(In_time, '$shift3_intime')) > 300)) 
    AND DATE_FORMAT(Date, '%Y-%m') = '$month'
";
$late_checkin_result = $con->query($late_checkin_sql);
$current_date = date('Y-m-d');
$start_date = date('Y-m-01', strtotime($month));
$days_in_month = date('t', strtotime($month));
$total_working_hours = $days_in_month * 10;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .header, .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .header {
            top: 0;
            border-bottom: 1px solid #000;
            padding: 10px 0;
        }
        .footer {
            bottom: 0;
            border-top: 1px solid #000;
            padding: 10px 0;
        }
        .footer .date {
            content: counter(page);
        }
        .container {
            margin-top: 50px; 
            margin-bottom: 50px;
        }
        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid black;
        }
        .report-info h6 {
            margin: 0;
        }
        .table {
            margin-top: 20px;
        }
        .table thead th {
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .table tbody td {
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
    </style>
</head>
<body>
<div class="container">
    <center><h2>Days Absent for Employee <?php echo $employee_id; ?></h2></center>
    <center><h4>Monthly report of <?php echo date('F', strtotime($month)); ?>, <?php echo date('Y', strtotime($month)); ?></h4></center>
    <div class="report-info">
        <h6>Total Number of Working Days: <?php echo $days_in_month; ?></h6>
        <h6>Total Number of Working Hours: <?php echo $total_working_hours; ?></h6>
    </div>

    <?php
    if ($absent_result->num_rows > 0) {
        echo "<table class='table table-bordered' id='datatable1' width='100%' cellspacing='0'>";
        echo "<thead><tr><th>Sl No</th><th>Employee ID</th><th>Name</th><th>Date</th></tr></thead>";
        echo "<tbody>";
        $sl_no = 1;
        while($row = $absent_result->fetch_assoc()) {
            echo "<tr><td>" . $sl_no++ . "</td><td>" . $row["Employee_ID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Date"] . "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No days absent records found for this employee.</p>";
    }
    ?>
<br>

    <center><h2>Late Check-ins for Employee <?php echo $employee_id; ?></h2></center>
    
    <div class="report-info">
        <h6>Total Number of Working Days: <?php echo $days_in_month; ?></h6>
        <h6>Total Number of Working Hours: <?php echo $total_working_hours; ?></h6>
    </div>

    <?php
    if ($late_checkin_result->num_rows > 0) {
        echo "<table class='table table-bordered' id='datatable2' width='100%' cellspacing='0'>";
        echo "<thead><tr><th>Sl No</th><th>Employee ID</th><th>Name</th><th>Date</th><th>Check-in Time</th></tr></thead>";
        echo "<tbody>";
        $sl_no = 1;
        while($row = $late_checkin_result->fetch_assoc()) {
            echo "<tr><td>" . $sl_no++ . "</td><td>" . $row["Employee_ID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Date"] . "</td><td>" . $row["In_time"] . "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No late check-ins records found for this employee.</p>";
    }
    ?>

    <div class="footer">
    </div>
</div>
</body>

</html>
