<!DOCTYPE html>
<?php include 'database.php';
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>view</title>

	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Our Custom CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/awesome/font-awesome.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<link rel="stylesheet" href="vendors/datatables/datatables.min.css">
</head>
<style>
	.dataTables_wrapper .dataTables_filter input {
		margin-left: 0.5em;
		display: none;
	}
	.container{
  height: 350px;
  width: 430px;
  position: relative;
}
.container .wrapper{
  position: relative;
  height: 300px;
  width: 100%;
  border-radius: 10px;
  background: #fff;
  border: 2px dashed #c2cdda;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.wrapper.active:hover .file-name{
  display: block;
}
 #custom-btn{
  margin-top: 30px;
  margin-left: 90px;
  display: block;
  width: 40%;
  height: 50px;
  border: none;
  outline: none;
  border-radius: 25px;
  color: #fff;
  font-size: 18px;
  vertical-align: middle;
  font-weight: 500;
  letter-spacing: 1px;
  text-transform: uppercase;
  cursor: pointer;
  background: linear-gradient(135deg,#3a8ffe 0%,#9658fe 100%);
}
.err{
	color: red;
	font-size: 20px;
	text-align: center;
	font-weight: 600;
	margin-left: 37%;

}
</style>

<body>
	<div class="wrapper">
		<!-- Sidebar Holder -->
		<?php include("left.php");?>
		<!-- Page Content Holder -->

		  <div id="content">
			<form method="post" enctype="multipart/form-data">
				Select image to upload:
				 <div class="container">
                <div class="wrapper">
                	 <div class="icon">
                  <i class="fas fa-cloud-upload-alt"></i>
               </div>
				<input type="file"  name="fileToUpload[]" id="fileToUpload[]" multiple="multiple" required>
				</div>
				<input type="submit" value="Upload Image"id="custom-btn" name="submit">
			</div>
			</form>

			<div class="line"></div>
<?php

$eid=$_GET['eid'];
$ename=$_GET['ename'];

$co  ="SELECT  `face_cap` FROM `emp_details` where `eid`='$eid'";
$res= mysqli_query($con, $co);
  $row55= mysqli_fetch_array($res);
 $cou=$row55[0]+1;
echo isset($_POST["submit"]);
if(isset($_POST["submit"])) 
{
	/*if($imageFileType != "jpg") 
	{
		$msg="Sorry, only JPG files are allowed.";
		$uploadOk = 0;
	}*/
	$uploadOk=1;
	if ($uploadOk == 0) {
		//$msg="Sorry, your file was not uploaded.";
	} else 
	{
	$imgcount=$cou;
	$total = count($_FILES['fileToUpload']['name']);
	
	for( $i=0 ; $i < $total ; $i++ ) 
	{
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$imgcount=$imgcount+1;
	    	$imgeid="images/".$eid."_".$ename."_".$imgcount.".png";

//echo move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i];
	    	//echo move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i];
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $imgeid)) 
		{
			$msg="The file ".htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			
		} else {
			$msg="Sorry, there was an error uploading your file.";
		}
		
		//echo $i;
	}
		
	}
	/*if ($uploadOk == 0) 
	{
		echo "<span class='err'>Sorry, only PNG files are allowed.<br> OR <br>There was an error uploading your file</span>";

	}*/
	
	//echo "<script>window.location = 'https://imbrutetechnologies.com/fathermuller/face_reg/index_reg_back.html?eid=$eid&ename=$ename';</script>";
	
	$update="UPDATE `emp_details` SET `face_cap`='$imgcount' where eid='$eid'";
	$res = mysqli_query($con, $update);
echo "<script>window.location = 'view.php';</script>";
	
	
}
?>

		</div>
	</div>
</body>
</html>
