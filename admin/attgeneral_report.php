<?php
require_once("database.php");
$sel_month = $_GET['month'];
$year = $_GET['year'];
$rtype = $_GET['rtype'];
$report_type = $_GET['rpt'];
$allshift = $_GET['shift'];

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

	#customers td,
	#customers th {
		border: 1px solid #ddd;
		padding: 8px;
	}

	#customers tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	#customers tr:hover {
		background-color: #ddd;
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

	hr {

		display: block;
		unicode-bidi: isolate;
		margin-block-start: 0.5em;
		margin-block-end: 0.5em;
		margin-inline-start: auto;
		margin-inline-end: auto;
		overflow: hidden;
		border-style: inset;
		border-width: 4px;
		webkit-text-decoration-color: black;
		/* Safari */
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

	.split-para {
		display: block;
		margin: 10px;
		font-size: 18px;
	}

	.split-para span {
		display: block;
		float: right;
		width: 19%;
		margin-left: 10px;
	}
</style>

<body onload="printfun()" style="font-family: Arial, Helvetica, sans-serif;">
	<div class="container">
		<!-- Sidebar Holder -->
		<center>
			<h1>All Shift Basic Report Of Monthly Attendance</h1>
			<h3>1-01-2022 To 31-01-2022</h3>
		</center>
		<?php $datt = date("Y-m-d");
		?>
		<style type="text/css">
			.split-para {
				display: block;
				margin: 10px;
				font-size: 18px;
			}

			.split-para span {
				display: block;
				float: right;
				width: 19%;
				margin-left: 10px;
			}
		</style>
		<p class="split-para">Company: Default <span>Printed On :
				<?php echo $datt ?>
			</span></p>
		<hr>
		</hr>
		<?php


		if ($sel_month == '01' || $sel_month == '03' || $sel_month == '05' || $sel_month == '07' || $sel_month == '08' || $sel_month == '10' || $sel_month == '12') {
			$maxday = 31;
		} elseif ($sel_month == '02') {
			$maxday = cal_days_in_month(CAL_GREGORIAN, 2, $year);
		} else {
			$maxday = 30;
		}
		$count = "1";

		for ($i = 1; $i <= $maxday; $i++) {
			$fromdate = $year . "-" . $sel_month . "-" . $i;
			$count = "1";
			$scount = "SELECT count(*) FROM attendance WHERE date(`Date`)=date('" . $fromdate . "')";
			$sresult = mysqli_query($con, $scount);
			$srowcount = mysqli_fetch_array($sresult);
			$rocount = $srowcount[0];
			$search = "";
			if ($rocount > 0) {
				$search = "select a.Employee_ID, a.Name, a.Department, a.Date, a.Shift, a.In_time, a.Out_time, a.Work_Hours, a.OT, a.Status, a.shift from attendance a  where Date='" . $fromdate . "' UNION
(SELECT eid,fname,dep_description,'" . $fromdate . "' Date,'' Shift,'00:00:00' In_time,'00:00:00' Out_time,'00:00:00' Work_Hours,'00:00:00' OT,'A' `Status`,'' `shift` FROM `emp_details` WHERE `eid` NOT IN (SELECT Employee_ID FROM attendance WHERE date(`Date`)=date('" . $fromdate . "'))and status='Active')order by Department";



				$result = mysqli_query($con, $search);
				$rowcount = mysqli_num_rows($result);
				if ($rowcount > 0) {
					$desdate = $i . "-" . $sel_month . "-" . $year;
					echo "</br>";
					echo "<span class='att'>Attendance Date:</span>" . $desdate . "</br>";
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
						$tempdep = '';
						while ($row = mysqli_fetch_array($result)) {
							$Department = $row['Department'];
							if ($Department != $tempdep) {
								echo "</table>";
								echo "<br>";
								echo "Dep Name:" . $Department;
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
							$tempdep = $Department;


							$Employee_ID = $row['Employee_ID'];
							$Name = $row['Name'];
							$Department = $row['Department'];
							$Date = $row['Date'];
							$Shift = $row[4];
							$In_time = $row['In_time'];
							$Out_time = $row['Out_time'];
							$Work_Hours = $row['Work_Hours'];
							$OT = $row['OT'];
							$Status = $row['Status'];
							?>
							<tr>
								<td>
									<?php echo $count; ?>
								</td>
								<td>
									<?php echo $Employee_ID; ?>
								</td>
								<td>
									<?php echo $Name; ?>
								</td>
								<td>
									<?php echo $Department; ?>
								</td>
								<td>
									<?php echo $Date; ?>
								</td>
								<td>
									<?php echo $Shift; ?>
								</td>
								<td>
									<?php echo $In_time; ?>
								</td>
								<td>
									<?php echo $Out_time; ?>
								</td>
								<td>
									<?php echo $Work_Hours; ?>
								</td>
								<td>
									<?php echo $OT; ?>
								</td>
								<td>
									<?php echo $Status;
									$count++; ?>
								</td>
							</tr>

							<?php

						}
				}

				echo "</table>";
			}//end if
		}//end for
		


		?>
		</table>
		<script type="text/javascript">
			function printfun() {
				window.print();
			}
		</script>
	</div>
</body>

</html>