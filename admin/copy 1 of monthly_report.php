<?php
require_once("database.php");

if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    echo "Error: Month not set.";
    exit;
}


$required_work_hours = 31 * 8;

$shift1_intime = '08:00:00';
$shift2_intime = '18:00:00';
$shift3_intime = '09:30:00';

// get active employee ids
$active_employee_sql = "
SELECT 
    Employee_ID
FROM 
    emp_details
WHERE 
    status = 'active'
";

// get attendance data
$attendance_sql = "
SELECT 
    a.Employee_ID, 
    a.Name, 
    a.Shift,
    SUM(CASE WHEN a.Status = 'A' THEN 1 ELSE 0 END) as AbsentDays,
    SUM(CASE 
        WHEN a.Shift = '1' AND TIME_TO_SEC(TIMEDIFF(a.In_time, '$shift1_intime')) > 300 THEN 1 
        WHEN a.Shift = '2' AND TIME_TO_SEC(TIMEDIFF(a.In_time, '$shift2_intime')) > 300 THEN 1 
        WHEN a.Shift = '3' AND TIME_TO_SEC(TIMEDIFF(a.In_time, '$shift3_intime')) > 300 THEN 1 
        ELSE 0 
    END) as LateCheckins,
    SEC_TO_TIME(SUM(TIME_TO_SEC(a.Work_Hours))) as TotalWorkSeconds,
    SEC_TO_TIME(SUM(TIME_TO_SEC(a.OT))) as Overtime
FROM 
    attendance a
WHERE 
    DATE_FORMAT(a.Date, '%Y-%m') = '$month' AND
    a.Employee_ID IN ($active_employee_sql)
GROUP BY 
    a.Employee_ID, 
    a.Name, 
    a.Shift
";

$attendance_result = $con->query($attendance_sql);


$current_date = date('Y-m-d');
$start_date = date('Y-m-01', strtotime($month));
$end_date = date('Y-m-t', strtotime($month));
$end_date = $current_date < $end_date ? $current_date : $end_date;
$days_in_month = date('t', strtotime($month));

$total_working_hours = $days_in_month * 10;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Monthly Attendance Report</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/awesome/font-awesome.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
    <style>
        .title-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .title-line h4 {
            margin: 0;
        }
    </style>
</head>
<body id="main_body">
    <form method="POST" action="">
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php include("left.php");?>

            <!-- Page Content Holder -->
            <div id="content">
                <div class="line"></div>
                <div class="panel panel-default sammacmedia">
                    <div class="panel-heading" id="div_select">
                        <div class="title-line">
                            <h4>Monthly report of <?php echo date('F', strtotime($month)); ?>, <?php echo date('Y', strtotime($month)); ?></h4>
                            <button id="export-to-excel" class="btn btn-primary">Export to Excel</button>
                        </div>
                    </div>
                    <div class="panel-body">
                    <div class="work-info">
    <h6>Total Number of Working Days: <?php echo $days_in_month; ?></h6>
    <h6>Total Number of Working Hours: <?php echo $total_working_hours; ?></h6>
</div>
                        <?php
                        // Check if there are results and display them
                        if ($attendance_result->num_rows > 0) {
                            ?>
                            <table class="table table-bordered" id="datatable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Shift</th>
                                        <th>No. of Days Absent</th>
                                        <th>No. of Late Check-ins</th>
                                        <th>Total Work Hours</th>
                                        <th>OT Hrs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    while($row = $attendance_result->fetch_assoc()) {
                                        $additional_absent_days = floor($row["LateCheckins"] / 3);
                                        $total_absent_days = $row["AbsentDays"] + $additional_absent_days;

                                        $total_work_hours_formatted = date('H:i:s', strtotime($row["TotalWorkSeconds"]));

                                        echo "<tr>";
                                        echo "<td>" . $count++ . "</td>";
                                        echo "<td>" . $row["Employee_ID"] . "</td>";
                                        echo "<td>" . $row["Name"] . "</td>";
                                        echo "<td>" . $row["Shift"] . "</td>";
                                        echo "<td><a href='days_absent.php?emp_id=" . $row["Employee_ID"] . "&month=" . $month . "'>" . $total_absent_days . "</a></td>";
                                        echo "<td><a href='late_checkins.php?emp_id=" . $row["Employee_ID"] . "&month=" . $month . "'>" . $row["LateCheckins"] . "</a></td>";
                                        echo "<td>" . $total_work_hours_formatted . "</td>"; // Display formatted work hours
                                        echo "<td><a href='ot_hours.php?emp_id=" . $row["Employee_ID"] . "&month=" . $month . "'>" . $row["Overtime"] . "</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "No data found for the specified month.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="vendors/datatables/datatables.min.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script>
    document.getElementById('export-to-excel').addEventListener('click', function() {
        /* Get the table data */
        var table = document.getElementById("datatable1");
        var data = [];
        for (var i = 0; i < table.rows.length; i++) {
            var row = [];
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                row.push(table.rows[i].cells[j].innerText);
            }
            data.push(row);
        }

        /* Create a workbook */
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        /* Create a downloadable blob */
        var wbout = XLSX.write(wb, {bookType:'xls', type:'binary'});
        var buf = new ArrayBuffer(wbout.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<wbout.length; i++) view[i] = wbout.charCodeAt(i) & 0xFF;
        var blob = new Blob([buf], {type:'application/octet-stream'});

        /* Create a downloadable link */
        var link = document.createElement('a');
        var filename = "Monthly_report_<?php echo date('F_Y', strtotime($month)); ?>.xls";
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
    });
</script>

    <style>
        .work-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px; 
}
.work-info h6 {
    margin: 0;
}

    </style>
</body>
</html>