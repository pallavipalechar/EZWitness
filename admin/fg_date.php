<?php
    require_once("database.php");
    $tdate=$_GET['tdate'];
    $fdate=$_GET['fdate'];?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>view</title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
</head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

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
hr{
    
    display: block;
    unicode-bidi: isolate;
    margin-block-start: 0.5em;
    margin-block-end: 0.5em;
    margin-inline-start: auto;
    margin-inline-end: auto;
    overflow: hidden;
    border-style: inset;
    border-width: 4px;
    webkit-text-decoration-color: black; /* Safari */  
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
.split-para      { display:block;margin:10px;font-size: 18px;}
.split-para span { display:block;float:right;width:19%;margin-left:10px;}
</style>

<body onload="printfun()">
    <div class="wrapper">
             <?php include("left.php");?>
                <div class="line"></div>
        
    <div class="panel panel-default sammacmedia">
            <div class="panel-heading" id="div_select">
        <h2 class="center">Genaral Attendance(Basic Report)</h2>
    <center><span class="date" style="font-size:21px;"> <?php echo "From:&nbsp;".$fdate."&nbsp;TO:&nbsp;".$tdate;?></span></center>
    
        
    </div>
        <hr></hr>
        <!-- <script type="text/javascript">
            function printfun(){
                window.print();
            }
        </script> -->
        <a href="export_excel.php?fdate=<?php echo $fdate;?>&tdate=<?php echo $tdate;?>"><button class="expt_btn">Export</button></a>
        <style type="text/css">
            .expt_btn{
                position: absolute;
                right: 50px;
            }
        </style>
        <br></br>
</body>
</html>

<?php

//month=01&rtype=monthly&rpt=absent&year=2020

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

    ?>
<table id="customers">
                                <tr> 
                                    <th>SR NO.</th>
                                    <th>Employee_ID</th>
                                    <th>Name</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    
                                </tr>
                                <?php
                                 $count="1";

                                 $search2="SELECT * FROM `emp_details`";
                                $result2 = mysqli_query($con, $search2);                      

                                while ($row2 = mysqli_fetch_array($result2)) 
                                {
                                    $epid=$row2[1];

                                    $search3="SELECT  Employee_ID , Name, count(status) FROM `attendance` WHERE Date>='$fdate' and Date<='$tdate' and Status='A'and Employee_ID='$epid' group by Employee_ID";
                                    $result3 = mysqli_query($con, $search3);                      

                                    $row3 = mysqli_fetch_array($result3);
                                    
                                        $absent=$row3[2];

                                /*$search="SELECT  Employee_ID , Name, count(status),(SELECT count(status) FROM `attendance` WHERE Status='A' and  Date>='$fdate' and Date<='$tdate' group by Employee_ID ) FROM `attendance` WHERE Date>='$fdate' and Date<='$tdate' and Status!='A' group by Employee_ID";*/
                                    $search="SELECT  Employee_ID , Name, count(status) FROM `attendance` WHERE Date>='$fdate' and Date<='$tdate' and Status!='A' and Employee_ID='$epid' group by Employee_ID";
                                    $result = mysqli_query($con, $search);                      

                                    $row = mysqli_fetch_array($result);
                                    
                                        $Employee_ID=$row2[1];
                                        $Name=$row2[2];
                                        $present=$row[2];

                                        /*$Date=$row[3];*/

                                        ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $Employee_ID; ?></td>
                                                <td><?php echo $Name; ?></td>
                                                <?php
                                                if ($present=='') 
                                                    {
                                                        $present=0;
                                                    }
                                                ?>
                                                <td><a href="prent_report.php?eid=<?php echo $Employee_ID;?>&fdate=<?php echo $fdate;?>&tdate=<?php echo $tdate;?>"><?php echo $present; ?></a></td>
                                                <td><?php 
                                                    if ($absent=='') 
                                                    {
                                                        $absent=0;
                                                    }
                                                    
                                                    ?>
                                                    <a href="absent_report.php?eid=<?php echo $Employee_ID;?>&fdate=<?php echo $fdate;?>&tdate=<?php echo $tdate;?>">
                                                    <?php
                                                    echo $absent;
                                                    ?>      
                                                </td>
                                               <!--  <td><?php echo $Date; ?></td> -->
                                                <?php $count++; ?>
                                            </tr>

                                    <?php

                                    
                                }
                            ?>
</table>

</div>
</div>
</div>
</body>
</html>
