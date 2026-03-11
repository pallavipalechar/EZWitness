<?php 
require_once("database.php");
$tdate=$_GET['tdate'];
    $fdate=$_GET['fdate'];
    $eid=$_GET['eid'];
$search1="SELECT * FROM `emp_details` WHERE eid='$eid'";
$result1 = mysqli_query($con, $search1);
$row = mysqli_fetch_array($result1);
$empid=$row['eid'];
$fname=$row['fname'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
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
  width: 40%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 21px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}
#customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 66%;
    margin-left: -158px;
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
img {
    width: 45%;
}
center {
    margin-top: 49px;
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
<body>
<div class="wrapper">
            <!-- Sidebar Holder -->
        <?php include("left.php");?>
        <h2 class="center">Present Report</h2>
<center>
    <center>
    <h3>Emp Id: <?php echo $empid;?></h3>
    <h3>Emp Name: <?php echo $fname;?></h3><br>
</center>
            <!-- Page Content Holder -->
            <div id="content">
<?php

     $count="1";
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
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <!-- <th>Image</th> -->
                                </tr>
                                <?php
                                foreach ($dates as $value)  
        { 
            $pday=date("l");
            $stime='';
            $etime='';

        if ($pday=='Saturday') 
        {
            $seld = "SELECT * FROM `bank_time` where id=2";
            $resd = mysqli_query($con, $seld);
            while ($rowd = mysqli_fetch_array($resd)) 
            {
                $stime=$rowd['stime'];
                $etime=$rowd['etime'];
            }
           
        }else{
            $seld = "SELECT * FROM `bank_time` where id=1";
            $resd = mysqli_query($con, $seld);
            while ($rowd = mysqli_fetch_array($resd)) 
            {
                $stime=$rowd['stime'];
                $etime=$rowd['etime'];
            }
        }


    $search = "SELECT In_time,Out_time,`Date` FROM `attendance` WHERE Employee_ID='$eid' and `Date`='$value'";
    $result = mysqli_query($con, $search);
    $rowcount=mysqli_num_rows($result);

        if ($rowcount>0) 
            {

                                    while ($row = mysqli_fetch_array($result)) 
                                    {
                                        $In_time=$row[0];
                                        $Out_time=$row[1];
                                        $Date=$row[2];
                                        ?>
                                            <tr>
                                                 <td><?php echo $count; ?></td>
                                            
                                            <td><?php echo $Date; ?></td>
                                            <td>
                                            <?php
                                            if ($In_time>$stime) 
                                            {
                                                echo '<p style="color: red;"> '.$In_time.'</p>';
                                            
                                            }else{
                                                  echo '<p> '.$In_time.'</p>';
                                            }

                                            ?>
                                            </td>
                                            <td>
                                                <?php
                                            if ($Out_time<$etime) 
                                            {
                                                echo '<p style="color: red;"> '.$Out_time.'</p>';
                                            
                                            }else{
                                                
                                                 echo '<p> '.$Out_time.'</p>';
                                            
                                            }

                                            ?>
                                                
                                            </td>
                                           <!--  <td><?php echo $Date; ?></td> -->
                                            <?php $count++; ?>
                                            </tr>

                                    <?php

                                    }
                                }

                                    
                                }
                                    ?></table></center>
                                    </div>
                                    <style type="text/css">
                                        .ltalert{
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 50%;
                                            background-color: red;
                                        }
                                    </style>
                                </div>
                                </body>
                                </html>
