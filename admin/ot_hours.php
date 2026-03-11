<?php
require_once("database.php");

$employee_id = $_GET['emp_id'];

if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    echo "Error: Month not set.";
    exit;
}


$sql = "
SELECT 
    Employee_ID,
    Name,
    Date,
    In_time,
    Out_time,
    OT
FROM 
    attendance 
WHERE 
    Employee_ID = '$employee_id'
    AND DATE_FORMAT(Date, '%Y-%m') = '$month'
    AND OT != '00:00:00'
";

$result = $con->query($sql);


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
    <title>OT Hours</title>
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
        <center><h2>OT Hours for Employee <?php echo $employee_id; ?></h2></center>
        <center><h4>Monthly report of <?php echo date('F', strtotime($month)); ?>, <?php echo date('Y', strtotime($month)); ?></h4></center>
        <div class="report-info">
            <h6>Total Number of Working Days: <?php echo $days_in_month; ?></h6>
            <h6>Total Number of Working Hours: <?php echo $total_working_hours; ?></h6>
        </div>
        <?php
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered' id='datatable1' width='100%' cellspacing='0'>";
            echo "<thead><tr><th>Sl No</th><th>Employee ID</th><th>Name</th><th>Date</th><th>In Time</th><th>Out Time</th><th>OT Hours</th></tr></thead>";
            echo "<tbody>";
            $sl_no = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $sl_no++ . "</td><td>" . $row["Employee_ID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Date"] . "</td><td>" . $row["In_time"] . "</td><td>" . $row["Out_time"] . "</td><td>" . $row["OT"] . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No OT hours records found for this employee.</p>";
        }
        ?>
    </div>
    <div class="footer">

    </div>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>