<?php

date_default_timezone_set('Asia/Kolkata');
include "database.php";
$select="SELECT fname,eid,face_cap FROM `emp_details`";
$result = mysqli_query($con,$select);
$imgstr=0;
$icount2=0;
$allimgstring='';
$sysdate = date("Y-m-d");
$maxdate=date("Y-m-d");
while($rowid = mysqli_fetch_array($result))
{
	$eid=$rowid['eid'];
	$fname=$rowid['fname'];
	$rdata=$rowid['face_cap'];
	$sql="SELECT ename,acc_rate,gdate,cap_image FROM `gen_attendance` WHERE `eid`='$eid' order by acc_rate limit 1";
	$res = mysqli_query($con,$sql);
	//$rowcount22=mysqli_num_rows ( $resr );
	while($row = mysqli_fetch_array($res))
	{
		$cap_image=$row['cap_image'];
		$ename=$row['ename'];
		
		
		$gdate=strtotime($row['gdate']);
		$systemdate=strtotime($sysdate);
		$f=$row['gdate'];
		if($gdate<=$systemdate)
		{
			
			for($i=1;$i<=$rdata;$i++)
			{
				$filename="../kmc_face_reg/database/".$eid."_".$fname."_".$i.".jpg";
				$modate=date("Y-m-d", filemtime($filename));
				if($modate=date("Y-m-d", filemtime($filename)))
				{
					if($modate<$maxdate)
					{
						$maxdate=$modate;
						$delfile=$filename;
						
					}
				}
			}
			//echo $src = '**************cap_img/'.$cap_image."*******".$ename."**************************";
			
			echo $src = 'cap_img/'.$cap_image;
			echo "****************************";
			echo $dest=$delfile;
			echo "****************************";
			copy($src,$dest);
			$delfile='';
			$maxdate=0;
			$modate=0;
		}
		
	}
}

//echo copy('cap_img/img_1808dffd-b958-11ec-84ce-d45d647f8418.jpg','../kmc_face_reg/database/102_Deekshith_2.jpg');
?>
