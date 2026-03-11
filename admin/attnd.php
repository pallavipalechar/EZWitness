<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
session_start();
		unset($_SESSION['dt']);

if(!isset($_SESSION['username']))
{
	header('location:main.php');

}
require_once("database.php");
				
    if(isset($_POST['d']))
	{
		if(!empty($_POST['dat']))
		{
		$t1=$_POST['dat'];
		list($hours, $mi,$sa) = explode('-', $t1);
		$sq1wx=mysqli_query($con,"select *  from salary  where mnt='$mi'  AND yr='$hours'");
		if(mysqli_num_rows($sq1wx)<1)
							{
		$d=$_POST['dat'];
		$t=$_POST['dat'];
		list($hours, $mon,$sa) = explode('-', $t);
		$mn=$mon;
		$yr=date("Y");
		$sq1=mysqli_query($con,"select * from attn where date='$d'");
		if(mysqli_num_rows($sq1)<1)
		{
				$sql="select * from emp where status='Inactive' ";
                $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                { 
			$i=$row['eid'];
			$sqlr=mysqli_query($con,"delete from attn where eid='$i'");
				}
			    $sql="select * from emp where status='Active' ";
                $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                { 
				$eid=$row['eid'];
				$name=$row['fname'];
				$sqlr=mysqli_query($con,"insert into attn (`eid`,`name`) VALUES  ('$eid','$name')");
				}
		$upd = mysqli_query($con, "UPDATE attn SET cin='',cout='' "); 
		$upo = mysqli_query($con, "UPDATE attn SET status='not taken' "); 
		$upp = mysqli_query($con, "UPDATE attn SET date='$d' ");
	
		$up = mysqli_query($con, "UPDATE attn SET month='$mn',year='$yr' "); 
		}
		else
		{
				$upp = mysqli_query($con, "UPDATE attn SET date='$d' ");
		}
		$sq = mysqli_query($con, "select * from attn where cin!='' AND cout!='' ");
		$ram=mysqli_num_rows($sq);
		$sq1 = mysqli_query($con, "select * from attn  ");
		$rm=mysqli_num_rows($sq1);
		if($ram!=$rm)
		{	
		unset($_SESSION['date']);
		$d=$_POST['dat'];
		$_SESSION['date']=$d;
		$_SESSION['time']=$tm;
		unset($_SESSION['ui']);
		}
		else{
			$_SESSION['ui']="$d Attendence already taken ";
						echo '<script>
						alert("'.$d.' Attendence already taken");
		</script>';}
			
	}
	else
	{
		echo '<script>
						alert("This month ('.$mi.') is already done..! And salary updated");
		</script>';
		}
	
		}
	else
	{
		   unset($_SESSION['date']);
			$_SESSION['date']="";		
	}
}

			$sq = mysqli_query($con, "select * from attn where  cout='' ");
					if(mysqli_num_rows($sq)<1)
			{
					$d=$_SESSION['date'];
				   $sq1w=mysqli_query($con,"select *  from atten  where date='$d'");
					if(mysqli_num_rows($sq1w)<1)
							{
								$d=$_SESSION['date'];
				$sql="select * from attn where date='$d' AND status='present' ";
                $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                { 
				$mn=$tm=date("M");
				$yr=date("Y");
				$eid=$row['eid'];
				$d=$_SESSION['date'];
				$time21=$row['date'];
				list($hours, $minutes,$sa) = explode('-', $time21);
				$sql=mysqli_query($con,"insert into atten (`eid`,`date`,mnt,yr) VALUES  ('$eid','$d','$minutes','$yr')");
				}
				if($sql === TRUE)
					{
				$mn=$minutes;
				$yr=date("Y");
				$up = mysqli_query($con, "UPDATE atten SET nd=nd+1 where mnt='$mn' AND yr='$yr'");
				     }
					 else
					 {
					 }
				}
								echo '
         <script type="text/javascript">
		 alert("attendence done");
         </script>';
		 
			}
			ELSE
			{
				echo '
         <script type="text/javascript">
         </script>';
			}
	
	
	
	if(isset($_POST['submit']))
	{
					$t1=$_SESSION['date'];
				    list($hours, $mi,$sa) = explode('-', $t1);
				   $sq1wx=mysqli_query($con,"select *  from salary  where mnt='$mi' AND yr='$hours'");
					if(mysqli_num_rows($sq1wx)<1)
							{
			$d=$_SESSION['date'];
			$sq = mysqli_query($con, "select * from attn where cin!='' AND cout!='' ");
			$ram=mysqli_num_rows($sq);
			$sq1 = mysqli_query($con, "select * from attn  ");
			$rm=mysqli_num_rows($sq1);
			if($ram!=$rm)
					{	
		$ch=$_POST['c'];
		$S=$_SESSION['date'];
		if($S=="")
		{
		unset($_SESSION['date']);
		$_SESSION['date']="Please select date";
		}
		else
		{

					unset($_SESSION['ui']);
					$d=$_SESSION['date'];
					$ch=$_POST['c'];
					if($ch=="cin")
					{
					$id = mysqli_real_escape_string($con,$_POST['ID']);
					$sq1=mysqli_query($con,"select * from attn where cout!='' AND eid='$id'");
					 while($row=mysqli_fetch_array($sq1))
						{
							$nme=$row['name'];
						}
					if(mysqli_num_rows($sq1)<1)
							{
					$d=$_SESSION['date'];
					$st1="working..";
					$tm=date("g:i",time ());
					$id = mysqli_real_escape_string($con,$_POST['ID']);
					$update = mysqli_query($con, "UPDATE attn SET status='$st1',date='$d',cin='$tm' WHERE eid = '$id' ");
					if($update === TRUE)
					{
						echo '
         <script type="text/javascript">
          alert("Success!");
          window.location.replace("attnd.php");
         </script>';
    
    }

else{
    echo '
         <script type="text/javascript">
          alert("Error!");
          window.location.replace("attnd.php ");
         </script>';
  }
				}
				else
				{
					echo '<script>
					alert("Name : '.$nme.'       Attendence is already taken.");
				</script>';	
				}
					}
			else if($ch=="cout")
			{
				$id = mysqli_real_escape_string($con,$_POST['ID']);
				$sq1=mysqli_query($con,"select * from attn where cin=''  AND eid='$id'");
					if(mysqli_num_rows($sq1)<1)
							{
				$d=$_SESSION['date'];
				$st1="Present";
				$tm=date("g:i",time ());
				$id = mysqli_real_escape_string($con,$_POST['ID']);
				$update = mysqli_query($con, "UPDATE attn SET status='$st1',date='$d',cout='$tm' WHERE eid = '".$id."' ");
				if($update === TRUE)
				{
				$id = mysqli_real_escape_string($con,$_POST['ID']);
				$sql="select * from attn where eid='$id' ";
                $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                { 
				$rt=$row['cin'];
				$st=$row['cout'];
				$time1 = $rt;
				$time2 = $st;
				list($hours, $minutes) = explode(':', $time1);
				$startTimestamp = mktime($hours, $minutes);
				list($hours, $minutes) = explode(':', $time2);
				$endTimestamp = mktime($hours, $minutes);
				$seconds = $endTimestamp - $startTimestamp;
				$minutes = ($seconds / 60) % 60;
				$hours = round($seconds / (60 * 60));
				$s=$hours.".".$minutes;
				$id = mysqli_real_escape_string($con,$_POST['ID']);
				$up = mysqli_query($con, "UPDATE attn SET inter='$s'+inter where eid='$id' ");
				}
				echo '
         <script type="text/javascript">
          alert("Success!");
          window.location.replace("attnd.php");
         </script>';
			    }
				else
				{
					echo '
         <script type="text/javascript">
          alert("Error!");
          window.location.replace("attnd.php");
         </script>';
				}
		}
		else
		{
		  echo '<script>
						alert("Please check in");
				</script>';	
		}
			}
		else
		{
		}
		}
					}
		else
		{		
							$d=$_SESSION['date'];
				   $sq1w=mysqli_query($con,"select *  from atten  where date='$d'");
					if(mysqli_num_rows($sq1w)<1)
							{
					$_SESSION['ui']="$d Attendence already taken ";
						echo '<script>
						alert("'.$d.' Attendence Already taken");
						</script>';
								$d=$_SESSION['date'];
				$sql="select * from attn where date='$d' ";
                $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                { 
				$mn=$tm=date("M");
				$yr=date("Y");
				$eid=$row['eid'];
				$d=$_SESSION['date'];
				$time2=$row['date'];
				list($hours, $minutes,$sa) = explode('-', $time2);
				$sql=mysqli_query($con,"insert into atten (`eid`,`date`,mnt,yr) VALUES  ('$eid','$d','$minutes','$yr')");
				}
				if($sql === TRUE)
					{
				$mn=date("M");
				$yr=date("Y");
				$up = mysqli_query($con, "UPDATE atten SET nd=nd+1 where mnt='$mn' AND yr='$yr'");
				     }
					 else
					 {
					 }
				}
				else
				{
					$_SESSION['ui']="$d Attendence already taken ";
						echo '<script>
						alert("'.$d.' Attendence Already taken");
						</script>';
				}
		}
			 
	}
	else
	{
	echo '<script>
						alert("This month ('.$mi.') is already done..! And salary updated");
						</script>';	
	}
	}
	
	
	if(isset($_POST['abs']))
	{
		$id = mysqli_real_escape_string($con,$_POST['ID']);
		$st="Absent";
		$d=date("Y-m-d");
		$update = mysqli_query($con, "UPDATE attn SET status='$st',date='$d',cin='00',cout='00' WHERE eid = '".$id."' ");
	}
	
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
            

            <!-- Page Content Holder -->
            <div id="content">
             
         
                
               <div class="wrapper">


           <?php include("left.php");?>


                <div class="line">

				</div>
                                           
    <div class="panel panel-default sammacmedia">
	<div class="alert alert-danger " role="alert">
	 <strong>
	 <?php
                            if(isset($_SESSION['date']))
                            {
                            echo "DATE:".$_SESSION['date'];
							}
							if(isset($_SESSION['ui']))
                            {
                            echo $_SESSION['ui'];
							}
                            ?>
							</strong>
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
				 </button>
        </div>
							
														 </div>
	<form method="post">
			<div class="col-md-6">
			<input type="date" class="form-control" name="dat" placeholder="date">
			</div>
			<div class="col-md-4">
			<nobr><input type="submit"  class="btn form-data" name="d" ></nobr>
			</div>
			</form>
			<br>
			<br>
			<br>
			<br>
            <div class="panel-heading">
			<?php
				$time2=$_SESSION['date'];
				list($hours, $minutes,$sa) = explode('-', $time2);
echo $hours;
?>				
						</div>
        <div class="panel-body">
                        <table class="table table-striped thead-dark table-bordered table-hover" id="myTable">
                <thead>
                <tr>
                    <th>No</th>
                    <th></th>
                    <th>Name</th>
                    <th></th>
                    </tr>
                </thead>
                    <?php
                                   $a=1;
                     $sql="select c.eid,c.name,e.pic from attn c,emp e where c.eid=e.eid and e.status='Active'";
              $query= mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($query))
                {
                          
                          ?>
                          <tr>
                              <td><?php echo $a;?></td> 
                                <td><?php $pic=$row['pic']; ?>
<img src="pic/<?php echo $pic; ?>" width="100" height="120"> </td>
                            <td><?php echo $row['name'];?></td>  
                            <td>
                   <button type="button" class="btn btn-default" data-target="#modal_update<?php echo $row['eid']?>"data-toggle='modal'><span class='glyphico fa fa-eye'></span></button>

                   <button type="button" class="btn btn-danger" data-target="#modal_up<?php echo $row['eid']?>"data-toggle='modal'>A<span class='glyphico fa fa-close'></span></button>				  
				   
             </td>

             <div class="modal fade" id="modal_update<?php echo $row['eid']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title"></h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                  <!-- <center><h4>Are you sure you want to delete this expense?</h4></center> -->
                  <!-- hidden fields -->
                 <input type="hidden" id="getID" name="ID" value="<?php echo $row['eid']?>">
				 <input type="hidden" name="n" value="<?php echo $row['fname'] ?>">
				<div class="form-row">
                  <div class="col">
                      <label>Check In</label>
                      <input type="radio" name="c" class="form-control" value="cin" required="">
                    </div>	
					<div class="col">
                      <label>Check Out</label>
                      <input type="radio" name="c" class="form-control" value="cout" required="">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <input type="submit" id="submit" name="submit"  value="Yes" class="btn btn-danger" />
                 </div>
                <!-- </div>
               </div> -->
              </form>
              </div>
            </div>
			
			
          </div>
		  
		   <div class="modal fade" id="modal_up<?php echo $row['eid']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Absent..!!?</h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                 <input type="hidden" id="getID" name="ID" value="<?php echo $row['eid']?>">
				 <input type="hidden" name="n" value="<?php echo $row['fname'] ?>">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <input type="submit" id="submit" name="abs"  value="Yes" class="btn btn-danger" />
                 </div>
				 </form>
					<?php
       $a++;
            }
						 ob_flush();
					?>

      </tbody>
    </table>

            </div>

        </div>
    </div>
    <!--End Advanced Tables -->
 </div>
</div>
                <!-- /. ROW  -->
            <div class="row"><!-- /. PAGE INNER  -->
            </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#myTable').dataTable( {
					"scrollY" : "460px",
					"scrollcolapse" : true,
					"paging " :false
				});

            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>




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
                 $('#myTable').DataTable();
             } );
         </script>
    </body>
</html>
