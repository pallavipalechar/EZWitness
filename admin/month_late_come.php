<?php
include 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="">
		<!-- <label>Emp ID:</label>
		<input type="text" name="empid_search" placeholder="EMP id">
		<input type="submit" name="search" value="Search"><br> -->
		<style>
		table, th, td {
		  border:1px solid black;
		}
		</style>
		<center><h1>Daily Attendance Late Coming (Basic Report)</h1>
		<h3>Nov 01 2021 To Nov 30 2021</h3>
		<label id="month_display">Month:</label>
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
		<input type="submit" id="search" name="search" value="Search"><br></br></center>
		<input type="submit" id="printpdf" name="printpdf" value="Search" onclick='prthpdeffun()'>
		<script type="text/javascript">
			function prthpdeffun(){
				document.getElementById('sel_month').style['display']= 'none';
				document.getElementById('month_display').style['display']= 'none';
				document.getElementById('search').style['display']= 'none';
				document.getElementById('printpdf').style['display']= 'none';
				window.print();
			}
		</script>
		<?php
		if (isset($_POST['search'])) 
		{
		?>
		
				
					<?php
					$sel_month=$_POST['sel_month'];
					if ($sel_month=='01'||$sel_month=='03'||$sel_month=='05'||$sel_month=='07'||$sel_month=='08'||$sel_month=='10'||$sel_month=='12') 
					{
						$maxday=31;
					}elseif ($sel_month=='02') {
						$maxday=28;
					}else{
						$maxday=30;
					}
						$count="1";
						for ($i=1; $i <=$maxday; $i++) 
						{ 
							
							$fromdate="2021-".$sel_month."-".$i;
							$search="select * from attendance where Date='".$fromdate."'";
							$result = mysqli_query($con, $search);
							$rowcount=mysqli_num_rows($result);
							if ($rowcount>0) 
							{
								$desdate=$i."-".$sel_month."-2021";
								echo "Attendance Date:".$desdate;
								?>
							<table>

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
						  			$Status=$row['Status'];

						  			if($Shift=="A" && $In_time>'08:30:00' && $In_time<'09:30:00') 
						  			{?>
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
									  		<td><?php echo $Status; $count++;?></td>
								  		</tr>

						  				<?php
						  			}

						  		?> 
						  		<?php

						  		}
							}?></table>



							<?php
						}
						}
					?>
		
	</form>
	

</body>
</html>