<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location:main.php');
}
require_once("database.php");
//equire_once("header.php");

if(isset($_POST['approve']))
{
$i=mysqli_real_escape_string($con,$_POST['ID']);
$dt=$_POST['dt'];
$op="Approved";
$update = mysqli_query($con, "UPDATE employee_shift SET status='$op' WHERE  s='$i'");
}

if(isset($_POST['can']))
{
$i=mysqli_real_escape_string($con,$_POST['ID']);
$dt=$_POST['dt'];
$op="Cancelled";
$update = mysqli_query($con, "UPDATE employee_shift SET status='$op' WHERE  s='$i'");
}

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
	    	if(isset($_POST['btn_sname']))
			{
				$sname=$_POST['sname'];
			$sdescp=$_POST['sdescp'];
			$start_time=$_POST['start_time'];
			$end_time=$_POST['end_time'];
				header("location:update_shift.php?sname=$sname&sdescp=$sdescp&start_time=$start_time&end_time=$end_time&btype=insert");
			}
      
		?>
 <div class="wrapper">

           <?php include("left.php");?>
           <div class="container">                              
        <div class="panel panel-default">
        <div class="panel-body">
        <center><h2>Shift Details</h2></center><br> 
                 <label>Shift Name</label><br>
                 <input type="text" class="textfd" name="sname" required=""><br>
                 <label>Shift Description</label><br>
                 <input type="text" class="textfd" name="sdescp" required=""><br>
                 <label>Start Time</label><br>
                 <input type="time" class="textfd" name="start_time" required="" value="<?php echo date('H:i'); ?>"><br>
                 <label>End Time</label><br>
                 <input type="time" class="textfd" name="end_time" required="" value="<?php echo date('H:i'); ?>"><br>
                 <input type="submit" name="btn_sname" style="background-color: #034f84;" value="Add Shift"><br><br>
             <style>
 .textfd{
  width: 45%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  width: 22%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=button] {
  width: 15%;
  background-color: #4CAF50;
  color: white;
  padding: 15px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}

.form{
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>

<br><table class="table table-striped thead-dark table-bordered table-hover">
            <tr>
            	<!--<th>Shift ID</th> -->
                <th>Shift Name</th>
                <th>Shift Description</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "select * from shift_details" ;
			$result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
               
                    echo "<tr>";
                   /* echo "<td>".$row['id']."</td>"; */
                    echo "<td>".$row['shift_name']."</td>";
                    echo "<td>".$row['shift_description']."</td>";
                    echo "<td>".$row['shift_start_time']."</td>";
                    echo "<td>".$row['shift_end_time']."</td>";
                    ?> 
                    <td><a href="update_shift.php?id=<?php echo $row['id']; ?>&sname=<?php echo urlencode($row['shift_name']); ?>&sdescp=<?php echo urlencode($row['shift_description']); ?>&start_time=<?php echo urlencode($row['shift_start_time']); ?>&end_time=<?php echo urlencode($row['shift_end_time']); ?>&btype=update"><i class="fa fa-edit" style="font-size:25px;color:blue" aria-hidden="true"></i></a></td>
                    <td><a href='update_shift.php?id=<?php echo $row['id']; ?>&btype=delete' onclick="return confirm('Are you sure you want to delete this shift?');">
                        <i class="fa fa-trash-o" style="font-size:25px;color:red" aria-hidden="true"></i></a></td>


            <div class="modal fade" id="modal_update<?php echo $row['s']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Are you sure want to approve</h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                 <input type="hidden" id="getID" name="ID" value="<?php echo $row['s']?>">
                 <input type="hidden" name="n" value="<?php echo $row['fname'] ?>">
                 <input type="hidden" name="dt" value="<?php echo $row['start'] ?>">
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <input type="submit" id="submit" name="approve"  value="Yes" class="btn btn-danger" />
                 </div>
                 </form>
                 </div>
                 </div>
                 </div>
                 </div>
                 
                 <div class="modal fade" id="modal_update1<?php echo $row['s']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Are you sure want to reject</h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                 <input type="hidden" id="getID" name="ID" value="<?php echo $row['s']?>">
                 <input type="hidden" name="n" value="<?php echo $row['fname'] ?>">
                 <input type="hidden" name="dt" value="<?php echo $row['start'] ?>">
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <input type="submit" id="submit" name="can"  value="Yes" class="btn btn-danger" />
                 </div>
                 </form>
                 </div>
                 </div>
                 </div>
                 
<?php
}
            ?>

        </table>
            </div>
                </div></div>
                <div class="line"></div>              
</DIV>
</DIV>

        <!-- jQuery CDN -->
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
