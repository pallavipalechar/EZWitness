<?php

require_once("database.php");
$sname=$_GET['sname'];
$sdescp=$_GET['sdescp'];
$start_time=$_GET['start_time'];
$end_time=$_GET['end_time'];
$btype=$_GET['btype'];
if ($btype == "insert") {
    $insert = "INSERT INTO `shift_details`(`shift_name`, `shift_description`, `shift_start_time`, `shift_end_time`) VALUES ('$sname', '$sdescp', '$start_time', '$end_time')";
    $result = mysqli_query($con, $insert);

    if ($result) {
        echo "<script>alert('Shift Added Successfully');</script>";
        header("location: shift_details.php");
        exit; 
    } else {
        echo "Error: " . mysqli_error($con);
    }

}


if ($btype=="delete") 
{
    $id=$_GET['id'];
    $delete="DELETE FROM `shift_details` WHERE id=$id";
    $result3 = mysqli_query($con, $delete);
    echo "<script>alert('Successfully Deleted shift')</script>";
    echo "Shift has been Deleted";
    header("location:shift_details.php");
}
if ($btype=="update") 
{
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>

          <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
       <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        
    </head>
    <body>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php
        if (isset($_POST['btn_update'])) 
        {
            $id=$_GET['id'];
            $sname=$_POST['sname'];
            $sdescp=$_POST['sdescp'];
            $start_time=$_POST['start_time'];
            $end_time=$_POST['end_time'];
            $update="UPDATE `shift_details` SET `shift_name`='$sname',`shift_description`='$sdescp',`shift_start_time`='$start_time',`shift_end_time`='$end_time' WHERE id=$id";
            $result2 = mysqli_query($con, $update);
            echo "<script>alert('shift has been Updated');</script>";
            echo "Shift has been Updated";
            header("location:shift_details.php");
        }
      
        ?>

    <div class="wrapper">

           <?php include("left.php");?>
           <div class="container">
           <div id="content">
           <div class="main_class" style="margin-left: 15px;" ><br>
                 <center>
                    <h2>Shift Details</h2>
                </center>  <br>
                 <label>Shift Name</label>
                 <input type="text" name="sname" class="form-control" style="width: 600px;" value="<?php echo $sname;?>" required><br><br>
                 <label>Shift Description</label>&nbsp;&nbsp;
                 <input type="text" name="sdescp" class="form-control" style="width: 600px;" value="<?php echo $sdescp;?>"><br><br>
                 <label>Start Time</label>&nbsp;&nbsp;
                 <input type="Time" name="start_time" class="form-control" style="width: 600px;" value="<?php echo $start_time;?>" required><br><br>
                 <label>End Time</label>&nbsp;&nbsp;
                 <input type="Time" name="end_time" class="form-control" style="width: 600px;" value="<?php echo $end_time;?>" required>&nbsp;&nbsp;
                 <br><input type="submit" onclick="return confirm('Shift has been Updated');" class="btn btn-primary" name="btn_update" value="Update Shift">
                </div> 
    </div></div></div>

 <script src="assets/js/jquery-1.10.2.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="assets/js/bootstrap.min.js"></script>

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

    <?php
}
?>
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
