 <?php 
 include 'database.php';
 $shift='';
$status='';
 $ot='';
 $insert='';
$query1="SELECT * FROM `shift_details` WHERE `shift_name`='A'";				
		$result1= mysqli_query($con,$query1);
		while($row1=mysqli_fetch_array($result1))
		{
			$t_start_time_a=$row1['thresold_start_time'];
			$t_end_time_a=$row1['thresold_end_time'];
		}

		$query2="SELECT * FROM `shift_details` WHERE `shift_name`='B'";				
		$result2= mysqli_query($con,$query2);
		while($row2=mysqli_fetch_array($result2))
		{
			$t_start_time_b=$row2['thresold_start_time'];
			$t_end_time_b=$row2['thresold_end_time'];
		}
		
		$query3="SELECT * FROM `shift_details` WHERE `shift_name`='C'";				
		$result3= mysqli_query($con,$query3);
		while($row3=mysqli_fetch_array($result3))
		{
			$t_start_time_c=$row3['thresold_start_time'];
			$t_end_time_c=$row3['thresold_end_time'];
		}
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
            $rd ='2022-07-08';
            //$rd ='2022-06-07';
            $prd_c=date('Y-m-d',(strtotime ( '-1 day' , strtotime ($rd) ) ));
			$dates = getBetweenDates($prd_c,$rd);
			//$dates = getBetweenDates('2022-06-04','2022-06-07');
			foreach ($dates as $value)
			{
			    
			 $qdr="SELECT * FROM `emp_details`";
				$result_id= mysqli_query($con,$qdr);
				while($row_id=mysqli_fetch_array($result_id))
				{	
				    
					$OT='';
					$pi_id=$row_id['eid'];
					$query12_de="SELECT * FROM `emp_details` WHERE eid='$pi_id' and `status`='Deactive'";		
					$result12_de= mysqli_query($con,$query12_de);
					$rowcount12_de=mysqli_num_rows($result12_de);
					if($rowcount12_de>0)
					{
						continue;
					}
                    $query12_delete="SELECT * FROM `attendance` WHERE `Date`='$value' and `Employee_ID`='$pi_id'";
					$result12_delete= mysqli_query($con,$query12_delete);
					$rowcount12_delete=mysqli_num_rows($result12_delete);
					if($rowcount12_delete>0)
					{
						$delete="DELETE FROM `attendance` WHERE `Date`='$value' and `Employee_ID`='$pi_id '";
						$delete_result= mysqli_query($con,$delete);
					}
					
					$Name=$row_id['fname']." ".$row_id['lname'];
					$query="select gtime, eid,`gdate` from gen_attendance where eid='$pi_id' and date(gdate)='$value' and cam_id='3' limit 1";
					$result= mysqli_query($con,$query);
					$rowcount2=mysqli_num_rows($result);


					$diff=0;
					 $In_time='';
					 $Employee_ID='';
					 $sdate=''; 
						while($row=mysqli_fetch_array($result))
						{
							$In_time=$row[0];
							$Employee_ID=$row[1];
							$sdate=$row[2];
							$date=date("Y-m-d", strtotime($sdate));
						}

						$query1="select gtime, eid,`gdate` from gen_attendance where eid='$pi_id' and date(gdate)='$value' and cam_id='4' order by gtime desc limit 1";
						$result1=$con->query($query1);
						$Out_time ="";
						
							while($row1=mysqli_fetch_array($result1))
							{	
							    
								$Out_time = $row1[0];
								if($rowcount2==0)
								{
									$sdate=$row1[2];
									
								}
							}
							    $status= '';
							    $rowcount12_dep=0;
							    $all_dep='';
							    $query12_dep="SELECT * FROM `emp_details` WHERE eid='$pi_id'";		
						 			
							$result12_dep= mysqli_query($con,$query12_dep);
							$rowcount12_dep=mysqli_num_rows($result12_dep);
							if($rowcount12_dep>0){
							    while($row12_dep=mysqli_fetch_array($result12_dep))
									{
        								$dep_id=$row12_dep['dep_id'];
        								$dep_name=$row12_dep['dep_description'];
        								if($dep_id!='' || $dep_name!='')
        								{
        								    $all_dep=$dep_name." (".$dep_id.")";
        								}
									}
							}
							
						    // Genreal shift 
						   
						 	$query12="SELECT * FROM `emp_details` WHERE `shift`='G' and eid='$pi_id'";		
						 			
							$result12= mysqli_query($con,$query12);
							$rowcount12=mysqli_num_rows($result12);
							if($rowcount12>0){
								$shift = 'G';
							}
							$In_time_1 = strtotime($In_time); 
							$t_start_time_aa = strtotime($t_start_time_a); 
							$t_end_time_aa   = strtotime($t_end_time_a); 
							$t_start_time_bb = strtotime($t_start_time_b); 
							$t_end_time_bb   = strtotime($t_end_time_b); 
							$t_start_time_cc = strtotime($t_start_time_c); 
							$t_end_time_cc   = strtotime($t_end_time_c);
							if($shift!='G')
							{
								if($t_start_time_aa<=$In_time_1 && $t_end_time_aa>=$In_time_1)
								{ 
									$shift="A";
								}
								else if($t_start_time_bb<=$In_time_1 && $t_end_time_bb>=$In_time_1)
								{
									$shift="B";
								}
								else if($t_start_time_cc<=$In_time_1 && $t_end_time_cc>=$In_time_1)
								{
									$shift="C";
									$query_c1="select gtime from gen_attendance where eid='$pi_id' and date(gdate)='$value' and cam_id='1' limit 1";
									$result_c1= mysqli_query($con,$query_c1);
									$rowcount2_c1=mysqli_num_rows($result_c1);
									while($row12_c=mysqli_fetch_array($result_c1))
									{
										$In_time=$row12_c[0];
									}

									$c_shift_date=date('Y-m-d',(strtotime ( '+1 day' , strtotime ($value) ) ));
									$query1_c="select gtime,eid from gen_attendance where eid='$pi_id' and date(gdate)=date('$c_shift_date') and cam_id='2'order by gtime desc limit 1";
									$result1_c= mysqli_query($con,$query1_c);
									//$result1_c=$con->query($query1_c);
									$rowcount_c=mysqli_num_rows($result1_c);
									//echo "*******************".$pi_id."*************".$rowcount_c."************";
									//echo "<br>";
									if($rowcount_c>0)
									{

										while($row1_c=mysqli_fetch_array($result1_c))
										{	
											$Out_time = $row1_c[0];
											$fd=$row1_c[1];
										}
										//$OT12 = new DateTime($In_time);
								 		//$OT22 = new DateTime($Out_time);
								 		$OT12 = new DateTime($value.$In_time);
						 				$OT22 = new DateTime($c_shift_date.$Out_time);
								 		$OTdiff2 = $OT12->diff($OT22);
								 		$diff=$OTdiff2->format('%h:%i:%s');
								 		/*
								 		
								 		echo "<br>";
								 		echo $c_shift_date."********".$In_time."*********".$Out_time."*******".$sdate;
								 		echo "<br>";
								 		echo "diff".$diff;
								 		echo "<br>";
								 		echo "//////////////////////".$pi_id."///////////////".$fd."////////////////";
								 		*/
								 		// END
									}
									/*
									if ($person_id=='4933') 
									{
										echo "**C**".$sdate."**".$c_shift_date."**I**".$In_time."**O**".$Out_time;
										echo "<br>";
									}*/
									
									
								}
								else{
									$shift='G';
								}
							}
							if ($shift!='C') 
							{
								$OT12 = new DateTime("2022-01-25 ".$In_time);
						 		$OT22 = new DateTime('2022-01-25 '.$Out_time);
						 		$OTdiff2 = $OT12->diff($OT22);
						 		$diff=$OTdiff2->format('%h:%i:%s');
						 	}
							if($diff>=8)
								{
									$O ='';
									$status='P';
									// $ot=$diff-8;
									// Current date and time
									 $datetime = date("2022-01-25 08:00:00");
									 $datetimeot = date("2022-01-25 ".$diff);

									$ot_time='2022-01-25 '.$diff;
									$ot_stat='2022-01-25 08:00:00';
									$OT12gv = new DateTime($ot_stat);
							 		$OT22gv = new DateTime($ot_time);
					 		
									$interval = $OT12gv->diff($OT22gv);
									$OT=$interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');

								}
								else if($diff<8)
								{
									$status='HD';
								}else
								{
									$status='A';
								}
								
								if ($In_time=='' || $Out_time=='') 
								{
									$diff='00:00:00';
									$OT='00:00:00';
									$status='A';
								}
								//$weekoff_day = date('l', $value);
								
								$unixTimestamp = strtotime($value);
                                $weekoff_day = date("l", $unixTimestamp);
								
							$weekoff_h="SELECT * FROM `weekoff` WHERE `eid`='$pi_id' and `title`='$weekoff_day'";
									$weekoff_res= mysqli_query($con,$weekoff_h);
									$week_rowcount=mysqli_num_rows($weekoff_res);
									if($week_rowcount>0)
									{
									    
										$status='WOP';
									}

								$gh_h="SELECT * FROM `gen_holyday` WHERE `start`='$value'";
									$gh_res= mysqli_query($con,$gh_h);
									$gh_rowcount=mysqli_num_rows($gh_res);
									if($gh_rowcount>0)
									{
										$status='GH';
									}
								$Name = mysqli_real_escape_string($con, $Name);
								$all_dep = mysqli_real_escape_string($con, $all_dep);
								$ot_time = date("H", strtotime($OT));
								if ($ot_time>='8') 
								{
									if ($shift="C") 
									{
										$spc_date=date('Y-m-d',(strtotime ( '+1 day' , strtotime ($value) ) ));
										$spc_query1_c="select gtime,eid from gen_attendance where eid='$pi_id' and date(gdate)=date('$spc_date') and cam_id='2'order by gtime limit 1";
										$spc_result1_c= mysqli_query($con,$spc_query1_c);
										$spc_rowcount_c=mysqli_num_rows($spc_result1_c);
										if($spc_rowcount_c>0)
										{

											while($spc_row1_c=mysqli_fetch_array($spc_result1_c))
											{	
												$Out_time = $spc_row1_c[0];
												$fd=$spc_row1_c[1];
											}
											$OT12 = new DateTime($value.$In_time);
							 				$OT22 = new DateTime($c_shift_date.$Out_time);
									 		$OTdiff2 = $OT12->diff($OT22);
									 		$diff=$OTdiff2->format('%h:%i:%s');
										}
									}
								}
							echo $insert="INSERT INTO `attendance`(`Employee_ID`,`Department`, `Name`, `Date`, `Shift`, `In_time`, `Out_time`,`Work_Hours`, `OT`, `Status`) VALUES ('$pi_id','$all_dep','$Name','$value','$shift','$In_time','$Out_time','$diff','$OT','$status')";
							$resinsert= mysqli_query($con,$insert);
							$shift = '';
							$OT='';
			   		}
				}
?>
