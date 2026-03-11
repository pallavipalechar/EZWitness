<?php

include "database.php";
//$attendence = "SELECT id,Date FROM attendance WHERE id=(SELECT MAX(id) FROM attendance)";
//$result = $con->query($attendence);
//if($result-> num_rows>0){
//  while($row=$result-> fetch_assoc()){
//    $fdate=$row['Date'];
//    $tdate=date("Y-m-d");
//  }
//}
$fdate = date('Y-m-01');

 #$fdate= date('Y-m-d', strtotime($date .' -1 day'));
 $tdate=date("Y-m-d");
  
//$fdate="2023/01/09";
//$tdate="2023/01/09";
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
 $delete="DELETE FROM `attendance` WHERE date(Date)>=date('$fdate') and date(Date)<=date('$tdate')";
 mysqli_query($con, $delete);
 
$dates = getBetweenDates($fdate, $tdate);
foreach ($dates as $value)  
{
    // $date =date("Y-m-d");
  $date=$value;
  $epm_id = "";
  $In_time ="";
  $em_id ="";
  $emp_name ="";
  $Date ="";

  
 
  $search="SELECT `eid`, `shift` FROM `emp_details`";
  $result = mysqli_query($con, $search);
  
  while($row= mysqli_fetch_array($result))
  {

     $epm_id =$row['eid'];
    $shift =$row['shift'];
     $search_1="SELECT * FROM gen_attendance WHERE gtime=(SELECT MIN(gtime) FROM gen_attendance WHERE eid ='$epm_id' and gdate='$date' LIMIT 1) and gdate='$date' and eid ='$epm_id' ";
      $result1 = mysqli_query($con, $search_1);
     while($row_1= mysqli_fetch_array($result1))
     {
       $In_time =$row_1[3];
       $em_id =$row_1['eid'];
       $emp_name =$row_1['ename'];
       $Date =$row_1['gdate'];
       $idf=$row_1['id'];

       $seldep11="SELECT * FROM attendance WHERE Employee_ID ='$epm_id' and `Date`='$date' and `In_time`='$In_time'";
      $rep11 = mysqli_query($con, $seldep11);
      $rowco11=mysqli_num_rows($rep11);
      if ($rowco11==0) 
      {
      $search_3="INSERT INTO `attendance`( `Employee_ID`, `Name`, `Date`, `In_time`, `Out_time` ) VALUES ('$em_id','$emp_name','$Date','$In_time','0')";
       $result2 = mysqli_query($con, $search_3);
      }
       $search_2="SELECT * FROM gen_attendance WHERE gtime=(SELECT MAX(gtime) FROM gen_attendance WHERE eid ='$epm_id' and gdate='$date ' LIMIT 1 ) and gdate='$date' and eid ='$epm_id' ";
       $result2 = mysqli_query($con, $search_2);

       while($row_2= mysqli_fetch_array($result2))
       {
         $Out_time =$row_2[3];

         $ad1=$date." ".$In_time;
         $ad2=$date." ".$Out_time; 
         $time1 = new DateTime($ad1);
         $time2 = new DateTime($ad2);
         $timediff = $time1->diff($time2);
         $timdif=$timediff->format('%h:%i:%s');
         $spl = explode(":", $timdif);
         $tfg= $spl[0];

        if ($tfg>'7') 
        {
          $OT1 = new DateTime("2021-12-15 ".$timdif);
          $OT2 = new DateTime('2021-12-15 08:00:00');
          $OTdiff = $OT1->diff($OT2);
          $OTdif=$OTdiff->format('%h:%i:%s');
          $Status="P";
        }else{
          $OTdif='00:00:00';
          $Status="HD";
        }
         $seldep22="SELECT * FROM attendance WHERE Employee_ID ='$epm_id' and `Date`='$date' and `In_time`='$In_time' and `Out_time`='$Out_time'";
      $rep22 = mysqli_query($con, $seldep22);
      $rowco22=mysqli_num_rows($rep22);
      if ($rowco22==0) 
      {
        $search_4="UPDATE `attendance` SET Out_time='$Out_time', Work_Hours='$timdif', OT='$OTdif', Status='$Status', Shift='$shift' where Employee_ID='$em_id' and `Date`='$date'";
        $result4 = mysqli_query($con, $search_4);
      }

      }
      $search_6="UPDATE `gen_attendance` SET flag='1' where `gdate`='$date'";
      $result4 = mysqli_query($con, $search_6);
    }    
}

}
echo "sucess";
//header("location:fg_date.php?fdate=$fdate&tdate=$tdate");    
?>