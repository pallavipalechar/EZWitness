<?php
require_once("database.php");
$sel_month=$_POST['sel_month'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php include("left.php");?>

            <!-- Page Content Holder -->
            <div id="content">
             
               
             <form method="POST" action="">  

                <div class="line"></div>
                                           
		<div class="panel panel-default sammacmedia">
            <div class="panel-heading">Employee Attendance details<br>
                <center><label>Month:</label>
        <select id="sel_month" name="sel_month">
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <input type="submit" name="search" value="Search"><br></br>
        <input type="submit" name="con_pdf" value="Convert To PDF">
        <button><a href="convert_pdf/month_present_print.php?sel_month=<?php echo $sel_month; ?>">PDF</a></button></center>
            </div>
        <div class="panel-body">

            <?php
            if (isset($_POST['con_pdf'])) 
        {
            $sel_month=$_POST['sel_month'];
            header("location:convert_pdf/month_present_print.php?sel_month=$sel_month");
        }
        if (isset($_POST['search'])) 
        {
        ?>
                <?php
                    $sel_month=$_POST['sel_month'];
                    $sys=date("Y");
                    if ($sel_month=='01'||$sel_month=='03'||$sel_month=='05'||$sel_month=='07'||$sel_month=='08'||$sel_month=='10'||$sel_month=='12') 
                    {
                        $maxday=31;
                    }elseif ($sel_month=='02') {
                        $maxday=cal_days_in_month(CAL_GREGORIAN,2,$sys);
                    }else{
                        $maxday=30;
                    }
                    $count="1";
                        for ($i=1; $i <=$maxday; $i++) 
                        { 
                            $fromdate=$sys."-".$sel_month."-".$i;
                            $search="select * from attendance where Status='WOP' and Date='".$fromdate."'";
                            $result = mysqli_query($con, $search);
                            $rowcount=mysqli_num_rows($result);
                            if ($rowcount>0) 
                            {
                                $desdate=$i."-".$sel_month."-".$sys;
                                echo "Attendance Date:".$desdate;
                                echo "<br></br>"
                                ?>
                            <table class="table table-striped thead-dark table-bordered table-hover" id="myTable">
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

                                while ($row = mysqli_fetch_array($result)) 
                                {
                                    $Employee_ID=$row['Employee_ID'];
                                    $Name=$row['Name'];
                                    $Department=$row['Department'];
                                    $Date=$row['Date'];
                                    $Shift=$row['Shift'];
                                    $In_time=$row['In_time'];
                                    $Out_time=$row['Out_time'];
                                    $Work_Hours=$row['Work_Hours'];
                                    $OT=$row['OT'];
                                    $Status=$row['Status'];

                                    ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $Employee_ID; ?></td>
                                            <td><?php echo $Name; ?></td>
                                            <td><?php echo $Department; ?></td>
                                            <td><?php echo $Date; ?></td>
                                            <td><?php echo $Shift; ?></td>
                                            <td><?php echo $In_time; ?></td>
                                            <td><?php echo $Out_time;?></td>
                                            <td><?php echo $Work_Hours; ?></td>
                                            <td><?php echo $OT; ?></td>
                                            <td><?php echo $Status;$count++; ?></td>
                                        </tr>

                                        <?php
                                    

                                ?> 
                                <?php

                                }
                            }?></table>



                            <?php
                        }
                        }
                    ?>
        
       </form>
         <script src="assets/js/jquery-1.10.2.js"></script>
         <script src="assets/js/bootstrap.min.js"></script>
         <script src="vendors/datatables/datatables.min.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
             $('sams').on('click', function(){
                 $('makota').addClass('animated tada');
             });
         </script>
         <script type="text/javascript">

        $(document).ready(function () {
 
            window.setTimeout(function() {
        $("#sams1").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
        });
            }, 5000);
 
        });
    </script>
         <script type="text/javascript">
             
             $(document).ready( function () {
                 $('#myTable').DataTable(({
                responsive: true,
                scrollX:"1500px",
                scrollY:"300px",
                scrollcolapse:"true",
                paging:"false",
        });
    });
         </script>
    </body>
</html>
