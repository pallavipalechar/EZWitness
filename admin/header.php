<?php
session_start();
if(!isset($_SESSION['username']))
{

header("location:main.php");
}
else{
    $uname=$_SESSION['username'];
}

?>
