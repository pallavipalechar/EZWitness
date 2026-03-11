<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con=new mysqli("localhost","root","","u829431996_ez_db",3306);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: " . $con->connect_error;
} else {
   // echo "Connected to MySQL database successfully!";
}
?>