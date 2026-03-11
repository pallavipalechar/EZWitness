 <?php
	require_once("database.php");
	$report_type=$_GET['rtype'];
	$year=$_GET['year'];
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
	<div class="container">
		<?php
		if ($report_type=="present") {
			$statement="Present";
		}else if ($report_type=="absent") {
			$statement="Absent";
		}
		else if ($report_type=="late_come") {
			$statement="Late Coming";
		}else if ($report_type=="early_going") {
			$statement="Early Going";
		}else{
			$statement="";
		}

		?>
		<h2 class="center">Daily Attendance of <?php echo $statement;?>(Basic Report)</h2>
	<center><span class="date" style="font-size:21px;">Year:<?php echo $year ?></span></center>
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
$dsyear=$year."-01-01";
$deyear=$year."-12-31";
$dates = getBetweenDates($dsyear, $deyear);

	
	if ($report_type=="absent"||$report_type=="present") 
	{

	foreach ($dates as $value)  
						{ 
							$count="1";
							if ($report_type=="absent") 
							{
								if ($allshift=="all") {
								$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status,e.eid, e.fname, e.shift from attendance a,emp_details e where a.Employee_ID=e.eid and a.Status='A' and a.Date='".$value."' ";
								}else{
									$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status,e.eid, e.fname, e.shift from attendance a,emp_details e where a.Employee_ID=e.eid and a.Status='P' and a.Date='".$value."' and e.shift='".$allshift."'";
								}
							}else if ($report_type=="present") 
							{
								if ($allshift=="all") {
								$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status,e.eid, e.fname, e.shift from attendance a,emp_details e where a.Employee_ID=e.eid and a.Status='P' and a.Date='".$value."'";
								}else{
									$search="select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status,e.eid, e.fname, e.shift from attendance a,emp_details e where a.Employee_ID=e.eid and a.Status='P' and a.Date='".$value."' and e.shift='".$allshift."'";
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
								
								echo "</br>";
								echo "<span class='att'>Attendance Date:</span>".$value. "</br>";
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

						  		while ($row = mysqli_fetch_array($result)) 
						  		{
						  			$Employee_ID=$row['Employee_ID'];
						  			$Name=$row['Name'];
						  			$Department=$row['Department'];
						  			$Date=$row['Date'];
						  			$Shift=$row[12];
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

						  		}
							}?></table>



							<?php
						}
	}

	if ($report_type=="late_come") 
	{
		$n=1;
		foreach ($dates as $value)  
		{ 
			$count="1";
			if ($allshift=="all") {
			$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.shift_start_time, e.shift from  attendance a, shift_details s,emp_details e where s.shift_start_time<a.In_time and a.Date='$value' and s.shift_name=e.Shift and e.eid=a.Employee_ID order by a.Date";
			}else{
				$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.shift_start_time, e.shift from  attendance a, shift_details s,emp_details e where s.shift_start_time<a.In_time and e.shift='$allshift' and a.Date='$value' and s.shift_name=e.Shift and e.eid=a.Employee_ID order by a.Date";
			}
			$result = mysqli_query($con, $query);

			$icountg=mysqli_affected_rows($con);
			if($icountg>0)
			{
								echo "</br>";
								echo "<span class='att'>Attendance Date:</span>".$value. "</br>";
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
			
			while ($row = mysqli_fetch_array($result)) 
			{
							$Employee_ID=$row[0];
						  	$Name=$row[1];
						  	$Department=$row[2];
						  	$Date=$row[3];
						  	$Shift=$row[12];
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
			
				
			}
		}
			}
			
	if ($report_type=="early_going") 
	{$n=1;
		foreach ($dates as $value)  
		{ 
			
			$count="1";
			if ($allshift=="all") {
			$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.shift_start_time, e.shift from  attendance a, shift_details s,emp_details e where s.shift_end_time>a.Out_time and a.Date='$value' and s.shift_name=e.Shift and e.eid=a.Employee_ID order by a.Date";
			}else{
				$query="select a.Employee_ID,a.Name,a.Department,a.Date,a.Shift,a.In_time,a.Out_time,a.Work_Hours,a.OT,a.Status,s.shift_name,s.shift_start_time, e.shift from  attendance a, shift_details s,emp_details e where s.shift_end_time>a.Out_time and e.shift='$allshift' and a.Date='$value' and s.shift_name=e.Shift and e.eid=a.Employee_ID order by a.Date";
			}
			$result = mysqli_query($con, $query);

			$icountg=mysqli_affected_rows($con);
			if($icountg>0)
			{
								echo "</br>";
								echo "<span class='att'>Attendance Date:</span>".$value. "</br>";
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
			
			while ($row = mysqli_fetch_array($result)) 
			{
							$Employee_ID=$row[0];
						  	$Name=$row[1];
						  	$Department=$row[2];
						  	$Date=$row[3];
						  	$Shift=$row[12];
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
			
				
			}
		}
			}
		
	?>

