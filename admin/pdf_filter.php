<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
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

<body>
	<div class="container">
		<h2 class="center">Daily Attendance Early Going (Basic Report)</h2>
	<center><span class="date" style="font-size:21px;"> Dec 01 2021 To Nov 30 2021</span></center>
	<div class="right">
		
	</div>
	<?php $datt =date("Y-m-d");
	?>
	<p class="split-para">Company: Default <span>Printed On :<?php echo $datt ?></span></p>
		<hr></hr>
		
</body>
</html>



<?php
//month=01&rtype=monthly&rpt=absent&year=2020
require_once("database.php");
$fdate=$_GET['fdate'];
$tdate=$_GET['tdate'];
$report_type=$_GET['rpt'];
$count = 0;
?>

<table  id="customers">
    <?php
    if ($report_type=="absent"||$report_type=="present") 
	{
        if ($report_type=="absent") 
							{
                                
								$search="select * from attendance where Status='A' and Date between '$fdate' AND '$tdate'";
							}else if ($report_type=="present") 
							{
								$search="select * from attendance where Status='P' and Date between '$fdate' AND '$tdate'";
							}
							else
							{
								echo "error";
							}
							
							$result = mysqli_query($con, $search);
							$rowcount=mysqli_num_rows($result);
							if ($rowcount>0) 
							{
							
								echo "</br>";
								// echo "<span class='att'>Attendance Date:</span>".$desdate. "</br>";
								echo "</br>";
								echo "</br>";
								echo "<span class='dep'>Department:Default</span>";
                                echo "</br>";
								echo "</br>";
								
								?>

        
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
									  		<td><?php echo $Status;$count ++?></td>
								  		</tr>
				<?php

					}
					
				}
            }?>
					</table>