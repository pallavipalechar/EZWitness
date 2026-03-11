<?php
	require_once("database.php");
	$sel_month=$_GET['month'];
	$year=$_GET['year'];
	$rtype=$_GET['rtype'];
	$report_type=$_GET['rpt'];
	$allshift=$_GET['shift'];
	
?>
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

<body onload="printfun()" style="font-family: Arial, Helvetica, sans-serif;">
	<form method="POST">
	<div class="container">
		<?php
		
		if ($rtype=='monthly' &&  $report_type=="General") 
		{
			$mainstate="Basic Report Of Monthly Attendance";
		}
		else if($rtype=='monthly' &&  $report_type=="present") 
		{
			$mainstate="Present Report Of Monthly Attendance";
		}
		else if($rtype=='monthly' &&  $report_type=="absent") 
		{
			$mainstate="Absent Report Of Monthly Attendance";
		}
		else if($rtype=='monthly' &&  $report_type=="late_come") 
		{
			$mainstate="Late Coming Report Of Monthly Attendance";
		}
		else if($rtype=='monthly' &&  $report_type=="early_going") 
		{
			$mainstate="Early Going Report Of Monthly Attendance";
		}else{
			$mainstate="Basic Report Of Monthly Attendance";
		}

		if ($allshift=='all') 
		{
			$addf="'All Shift ' - ".$mainstate;
		}else if ($report_type=='absent') 
		{
			$addf="'All Shift ' - ".$mainstate;
		}else{
			$addf="'".$allshift." Shift ' - ".$mainstate;
		}
		?>

		<h2 class="center"><?php echo $addf;?></h2>
	<center><span class="date" style="font-size:21px;"> 
	<?php 
		if ($sel_month=='01'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='02'){
			$maxday=30;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='03'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='04'){
			$maxday=30;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='05'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='06'){
			$maxday=30;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='07'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='08'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='09'){
			$maxday=30;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='10'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		else if($sel_month=='11'){
			$maxday=30;
			$sday=1;
			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;
		}
		 else if($sel_month=='12'){
			$maxday=31;
			$sday=1;

			$fromdate=$sday."-".$sel_month."-".$year;
			$Todate=$maxday."-".$sel_month."-".$year;
			echo $fromdate."&nbspTo&nbsp"  .$Todate ;

		}else{
			
		}
		 
		
	?>
</span></center>
	<div class="right">
		
	</div>
	<?php $datt =date("Y-m-d");
	?>
	<p class="split-para">Company: Default <span>Printed On :<?php echo $datt ?></span></p>
		<hr></hr>
		<script type="text/javascript">
			function printfun(){
				window.print();
			}
		</script>
		


<?php

//month=01&rtype=monthly&rpt=absent&year=2020

	if ($sel_month=='01'||$sel_month=='03'||$sel_month=='05'||$sel_month=='07'||$sel_month=='08'||$sel_month=='10'||$sel_month=='12') 
	{
		$maxday=31;
	}elseif ($sel_month=='02') {
		$maxday=cal_days_in_month(CAL_GREGORIAN,2,$year);
	}else{
		$maxday=30;
	}
	$count="1";
	if ($report_type=="absent"||$report_type=="present"||$report_type=="General") 
	{
	for ($i=1; $i <=$maxday; $i++) 
						{ 
							$fromdate=$year."-".$sel_month."-".$i;
							if ($report_type == "General") {
								 /* $search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status, a.shift from attendance a  where Date='".$fromdate."' UNION
SELECT eid,fname,dep_description,'00:00:00' Date,'' Shift,'00:00:00' In_time,'00:00:00' Out_time,'00:00:00' Work_Hours,'00:00:00' OT,'A' `Status`,'' `shift` FROM `emp_details` WHERE `eid` NOT IN (SELECT Employee_ID FROM attendance WHERE date(`Date`)=date('".$fromdate."'))

								  ";*/
								  header("location: attgeneral_report.php?month=$sel_month&rtype=$rtype&rpt=$report_type&year=$year&shift=$allshift");

								  //header("location: attgeneral_report.php?month=$sel_month&rtype=$rtype&rpt=$report_type&year=$year&shift=$allshift");

							}
							else if ($report_type=="absent") 
							{/*
								if ($allshift=="all") {
									$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status from attendance a where a.Status='A' and a.Date='".$fromdate."' ";
								}else{
									$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status from attendance a where a.Status='A' and a.Date='".$fromdate."' and a.Shift='".$allshift."'";
								}*/
								
								header("location: attabsent_report.php?month=$sel_month&rtype=$rtype&rpt=$report_type&year=$year&shift=$allshift");
								/*$scount="SELECT count(*) FROM attendance WHERE date(`Date`)=date('".$fromdate."')";
		$sresult = mysqli_query($con, $scount);
		$srowcount=mysqli_fetch_array($sresult);
		$rocount=$srowcount[0];
		$search=''; 
		if ($rocount>0) 
		{
			$search="SELECT * FROM `emp_details` WHERE `eid` NOT IN (SELECT Employee_ID FROM attendance WHERE date(`Date`)=date('".$fromdate."'))";
		}*/
								
							}else if ($report_type=="present") 
							{
								if ($allshift=="all") {
							 	$search="select distinct a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status from attendance a where (a.Work_Hours>='8:00:00' or a.`status`='WeekOff' or a.`status`='Gholyday') and a.Date='".$fromdate."'order by a.Department;";
								}else{
								$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status from attendance a where (a.Work_Hours>='8:00:00' or a.`status`='WeekOff' or a.`status`='Gholyday') and a.Date='".$fromdate."' and a.Shift='".$allshift."' order by a.Department";
								}
							}
							else
							{
								echo "error";
							}
							
							$result = mysqli_query($con, $search);
							$rowcount=mysqli_num_rows($result);
							if ($rowcount>0) 
							{
								$desdate=$i."-".$sel_month."-".$year;
								echo "</br>";
								echo "<span class='att'>Attendance Date:</span>".$desdate. "</br>";
								echo "</br>";
								echo "</br>";
								echo "<span class='dep'>Department:</span>";
								?>
							<table id="customers">
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
								$tempdep='';
						  		while ($row = mysqli_fetch_array($result)) 
						  		{
						  			$Department=$row['Department'];
							  			if ($Department!=$tempdep) 
						  			{
						  				echo "</table>";
						  				echo "<br>";
						  				echo "Dep Name:".$Department;
						  				echo "<br>";
						  				echo "<table id='customers'>";
						  				echo "<tr> 
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
								</tr>";
						  			}
						  			$tempdep=$Department;
						  			
						  			$Employee_ID=$row['Employee_ID'];
						  			$Name=$row['Name'];
						  			$Department=$row['Department'];
						  			$Date=$row['Date'];
						  			$Shift=$row[4];
						  			$In_time=$row['In_time'];
						  			$Out_time=$row['Out_time'];
						  			$Work_Hours=$row['Work_Hours'];
						  			$OT=$row['OT'];
						  			$Status=$row['Status'];
						  			/*}
*/						  			?>
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

						  		}
							}?></table>



							<?php
						}
	}

	// 
	if ($report_type == "late_come") {
		//$n = 1;
		//for ($i = 1; $i <= $maxday; $i++) {
			//$fromdate = $year . "-" . $sel_month . "-" . $i;
			//if ($allshift == "all") {
			//echo "inside late come";
			header("Location: monthly_report.php?month=$year-$sel_month");
				
			//}
		//}
	}
			
	if ($report_type=="early_going") 
	{$n=1;
		for ($i=1; $i <=$maxday; $i++) 
		{ 
			
			$fromdate=$year."-".$sel_month."-".$i;
			if ($allshift=="all") 
			{
			$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.thres_e from attendance a, shift_details s where s.shift_name=a.Shift and CONVERT(s.thres_e,TIME)>CONVERT(a.Out_time,TIME) and a.Date='$fromdate' and a.Status!='A' order by a.Department";
			}else{
				$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.thres_e from attendance a, shift_details s where s.shift_name=a.Shift and CONVERT(s.thres_e,TIME)>CONVERT(a.Out_time,TIME) and a.Shift='$allshift' and a.Date='$fromdate' and a.Status!='A' order by a.Department";

			}
			$result = mysqli_query($con, $query);

			$icountg=mysqli_affected_rows($con);
			if($icountg>0)
			{
				$desdate=$i."-".$sel_month."-".$year;
								echo "</br>";
								echo "<span class='att'>Attendance Date:</span>".$desdate. "</br>";
								echo "</br>";
								echo "<span class='dep'>Department:</span>";
			?>
			<table id="customers">
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
			$tempdep='';
			while ($row = mysqli_fetch_array($result)) 
			{
				$Department=$row['Department'];
							  			if ($Department!=$tempdep) 
						  			{
						  				echo "</table>";
						  				echo "<br>";
						  				echo "Dep Name:".$Department;
						  				echo "<br>";
						  				echo "<table id='customers'>";
						  				echo "<tr> 
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
								</tr>";
						  			}
						  			$tempdep=$Department;
							$Employee_ID=$row[0];
						  	$Name=$row[1];
						  	$Department=$row[2];
						  	$Date=$row[3];
						  	$Shift=$row[4];
						  	$In_time=$row[5];
						  	$Out_time=$row[6];
						  	$Work_Hours=$row[7];
						  	$OT=$row[8];
						  	$Status=$row[9];?>
						  	<tr>
						  					<td><?php echo $n; ?></td>
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
					$n++;
				}
			?>
		</table>
			<?php
				
			}
		}
			}
		
	?>
</form>
</body>
</html>
