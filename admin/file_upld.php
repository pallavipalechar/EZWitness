<?php
include 'database.php';

require 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';

$fileList = glob('documents/*.csv');
foreach($fileList as $filename){
    if(is_file($filename)){
        if($filename=="documents/attendance11.csv")
        {
        	$uploadfile=$filename;
			$objExcel=PHPExcel_IOFactory::load($uploadfile);
			foreach($objExcel->getWorksheetIterator() as $worksheet)
			{
				$highestrow=$worksheet->getHighestRow();

				$a="ins";
				for($row=2;$row<=$highestrow;$row++)
				{
					//$id=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
					$Employee_ID=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
					$Name =$worksheet->getCellByColumnAndRow(2,$row)->getValue();

					$Department = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
					$sdate = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
					$date=date("Y-m-d", strtotime($sdate));
					$Shift =$worksheet->getCellByColumnAndRow(5,$row)->getValue();
					$In_time =$worksheet->getCellByColumnAndRow(6,$row)->getValue();
					$Out_time	=$worksheet->getCellByColumnAndRow(7,$row)->getValue();
					$Work_Hours =$worksheet->getCellByColumnAndRow(8,$row)->getValue();
					$Status =$worksheet->getCellByColumnAndRow(9,$row)->getValue();

					$ad1=$date." ".$In_time;
					$ad2=$date." ".$Out_time;
					
					$time1 = new DateTime($ad1);
					$time2 = new DateTime($ad2);
					$timediff = $time1->diff($time2);
					$timdif=$timediff->format('%h:%i:%s');

					$OT1 = new DateTime("2021-12-15 ".$timdif);
					$OT2 = new DateTime('2021-12-15 08:00:00');
					$OTdiff = $OT1->diff($OT2);
					$OTdif=$OTdiff->format('%h:%i:%s');

					$select="select * from attendance where `Employee_ID`='$Employee_ID' and `Name`='$Name' and `Department`='$Department' and `date`='$date'and `Shift`='$Shift'and `In_time`='$In_time'and `Out_time`='$Out_time'and `Work_Hours`='$Work_Hours'and `Status`='$Status'";
					$result = mysqli_query($con, $select);
							$rowcount=mysqli_num_rows($result);
							if ($rowcount==0) 
							{
								$a=$a.$row;
								$$a="INSERT INTO `attendance`(`Employee_ID`, `Name`, `Department`, `Date`, `Shift`, `In_time`, `Out_time`, `Work_Hours`, `Status`,`OT`)
								  VALUES ('$Employee_ID' , '$Name', '$Department', '$date','$Shift','$In_time','$Out_time', '$timdif', '$Status','$OTdif')";
								$a="ins";
							}
				
				}
				for($i=2;$i<=$highestrow;$i++)
				{
					$a=$a.$i;
					$b=$$a;
					$insertres=mysqli_query($con,$b);
					$a="ins";
				}
				
			}
			echo "<script>alert('Successfully Attendance Updated')</script>";
        }
    }   
}
header("location:monthrep.php");
?>