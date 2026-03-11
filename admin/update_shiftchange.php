<?php
require_once("database.php");
$sts=$_POST['shift_name_change'];

		foreach($_POST['check_list'] as $sele)
        {
           $query = "UPDATE `emp_details` SET `shift`='$sts' WHERE eid='$sele'";
            $res=mysqli_query($con,$query);
            $query1 = "UPDATE `attendance` SET `Shift`='$sts' WHERE `Employee_ID`='$sele'";
            $res=mysqli_query($con,$query1);

        }
        echo "Shift has been Updated";
?>
