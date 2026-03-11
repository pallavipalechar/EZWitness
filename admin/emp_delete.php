<?php
require_once("database.php");
$eid = $_GET['eid'];
$select = "DELETE FROM `emp_details` WHERE `eid`='$eid'";
$query = mysqli_query($con, $select);

$folder_path = "/opt/lampp/htdocs/ez/python/database_bw";

$files = glob($folder_path . "/". "$eid*");
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

header('location:view.php');
?>
