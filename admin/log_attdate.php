<?php 
include("header.php");
require_once("database.php");
    $tdate=$_GET['tdate'];
    $fdate=$_GET['fdate'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery.min.js"></script>

    <!-- Page level plugin JavaScript--><script src="assets/js/jquery.dataTables.min.js"></script>

    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">

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
 #content {
                                
    padding: 1px;
    min-height: auto;
    transition: all 0.3s;
    width: 90%;
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
    margin-top: 4px;
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
    border-width: 2px;
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
        <div class="container">
            <!-- Page Content Holder -->
          <!-- <div id="content">
                <div class="line">
				</div> -->
<form method="POST" action="#"><br>
    

<center>
   <h2>Attendance Log</h2>
</center>
<center>
<?php
$dis_tdate = date("d-m-Y", strtotime($tdate));
$dis_fdate = date("d-m-Y", strtotime($fdate));
?>
<p style="color: black; font-size: 20px;"><b>From:&nbsp <?php echo $dis_fdate;?>&nbsp&nbsp&nbsp
To: &nbsp<?php echo $dis_tdate;?>
</b>
</p>
<br>
<div class="font" style="margin-left: 15px;">
    <!--<label>Employee ID:</label>
    <input type="text" name="txt_eid">
    <button name="search">Search</button>
    <br>
    <button name="retrain" class="button">Retrain</button>
    <style type="text/css">
        .button {
  background-color: #f44336; 
  position: relative;
  left: -559px;
  border: none;
  color: white;
  padding: 14px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 3px 1px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius: 10px;
}
    </style>
</div>-->
<?php
    $sdname='';
    if (isset($_GET['eid'])) 
    {
        $ird=$_GET['eid'];
        $seldata="SELECT * FROM `emp_details` WHERE `eid`='$ird'";
        $resk= mysqli_query($con, $seldata);
        $rowsd = mysqli_fetch_array($resk);
        $sdname=$rowsd['fname'];
        $search = "SELECT DISTINCT * FROM `gen_attendance`  WHERE `eid`='$ird' and gdate between '$fdate' and '$tdate' order by id desc";
       
    }else
    {
        $search = "SELECT DISTINCT * FROM `gen_attendance`  WHERE gdate between '$fdate' AND '$tdate' order by id desc" ;
    }
    if (isset($_POST['retrain'])) 
    {
        $count=1;
        $img1='';
        $img2='';
        $img3='';
        $img4='';
        $img5='';

        foreach($_POST['selc'] as $value)
        {
              //echo "value : ".$value.'<br/>';
            if ($count==1) 
            {
                $img1=$value;
            }else if ($count==2) 
            {
                $img2=$value;
            }else if ($count==3) {
                $img3=$value;
            }else if ($count==4) {
                $img4=$value;
            }else if ($count==5) {
                $img5=$value;
            }else
            {

            }
            $count++;
        }
       
        if ($count<6 || $count>6) 
        {
            echo "<script>alert('Alert select 5 Photos only')</script>";
        }else{
            header("location: ../face_reg/index_retrain_24.html?img1=".$img1."&img2=".$img2."&img3=".$img3."&img4=".$img4."&img5=".$img5."&eid=".$ird."&ename=".$sdname);
        }
    }
    if (isset($_POST['search'])) 
    {
       $txt_eid=$_POST['txt_eid'];
       $fdate=$_GET['fdate'];
       header('location: dompage.php?eid='.$txt_eid.'&fdate='.$fdate.'&tdate='.$tdate);
    }
    $result = mysqli_query($con, $search);
    $rowcount=mysqli_num_rows($result);
    $count=1;
   
    if ($rowcount>0) 
    {
?>
<!-- <input type="submit" name="gen_att" id="gen_att" value="Generate Attendance"> -->
<table class="table table-bordered" id="datatable1">
     <thead>
                                <tr> 
                                    <!--<th>Select</th>-->
                                    <th>Sl.No</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
				                    <th>Cam Name</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    while ($row = mysqli_fetch_array($result)) 
                                    {
                                        $Employee_ID=$row['eid'];
                                        $Name=$row['ename'];
                                        $gdate=$row['gdate'];
                                        $gtime=$row['gtime'];
					$cname=$row['cam_id'];
                                        $fpath=$row['cap_image'];
                                        ?>
                                            <tr>
                                                <!--<td><input type="checkbox" name="selc[]" value="<?php echo $fpath;?>"></td> -->
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $Employee_ID; ?></td>
                                                <td><?php echo $Name; ?></td>
                                                <td>
                                                        <?php 
                                                        $dob = $row['gdate'];
                                                        echo date('d-m-Y', strtotime($gdate));
                                                        ?>
                                                    </td>                                                
                                                    <td><?php echo $gtime; ?></td>
					                         	<td><?php echo $cname; ?></td>
                                               <td><img src="<?php echo "cap_img/".$fpath;?>"><?php  $count++; ?> </td>
                                            </tr>

                                    <?php
                                    }
                                    }else{
                                        echo "<td class='stl' style='font-size:30px'>No Records Found </td>";
                                    }?>
                                </tbody></table></center>
                                    </div>
                                </div>
                                <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
       // $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
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
                                </form>
                                </body>
                                </html>
                                <style>
                               .font {
                                    font-size: 1pc;
                                }
     
}
                                </style>

<style>
    body {
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
    .container {
        max-width: 100%;
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
</style>


