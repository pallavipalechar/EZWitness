<?php
session_start();
$session=session_id();
include "database.php";
$adname=$_GET["uname"];
$adpass=$_GET["pwd"];
$query="SELECT adname, adpass, role FROM login WHERE adname='$adname'";
$result=$con->query($query);
$dbpwd="";
$role="";
$uid="";
while($row=mysqli_fetch_array($result))
{
	$name=$row[0];
	$dbpwd=$row[1];
	$role=$row[2];
} 

if($dbpwd==$adpass){
	$_SESSION['username']=$name;
    $_SESSION['role']=$role;	

echo "<script>window.location='dashboard.php';</script>";
}
else
{
echo "<script>window.location='main.php';</script>";
}
?>
