<?php
require_once("database.php");
$date ='Y-m-d'
$sql="SELECT * FROM `gen_attendance` WHERE `gdate`='$date' LIMIT 1";
$query= mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($query))
	{
		$In_time=$row['gtime'];
		$Employee_ID=$row['eid'];
		$Name=$row['ename'];
		$Date=$row['gdate'];
	}
	
echo $sql="SELECT * FROM `gen_attendance` WHERE `gdate`='$date' order by time desc LIMIT 1";
$query= mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($query))
	{
		$Out_time=$row['gtime'];
	}
$ad1=$date." ".$In_time;
$ad2=$date." ".$Out_time; 
$time1 = new DateTime($ad1);
$time2 = new DateTime($ad2);
$timediff = $time1->diff($time2);
$timdif=$timediff->format('%h:%i:%s');

echo $sql="INSERT INTO `attendance`(`Employee_ID`, `Name`, `Date`, `In_time`, `Out_time`, `Work_Hours`) VALUES ('$Employee_ID','$Name','$In_time','$Out_time','$timdif)";
$query= mysqli_query($con,$sql);

?>