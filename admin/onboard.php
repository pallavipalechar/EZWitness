<?php
 include("header.php");
 include("database.php");

  $sql = "SELECT eid, fname FROM `emp_details`";
  $result = $con->query($sql);
  $jsonData = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $fname = $row['fname'];
          unset($row['fname']);
          $jsonData[$fname] = $row;
      }
  }
  $jsonData1 = json_encode($jsonData);

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>
		

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
         
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    </head>
    <style>
        .image-container {
            display: flex;
            flex-direction: row; 
            max-height: 400px;
            overflow-x: auto; 
        }
        .imgclass{
    padding: 10px;
    }

        .image-item {
            margin: 10px;
        }

        .image-item img {
            max-width: 200px;
            max-height: 200px;
        }
#img-select-btn{
    margin-left:75px;
    margin-top:10px
}
.uploadbutton{
    background-color:#4AD00C;
    padding: 2px 2px 2px 2px;
    margin: 4% 20% 5% 15%;
    width: fit-content;
    height: 35px;
    border-radius: 8px;
    position: relative;
}
.btn-caputre{
  margin:5% 0% 2% 0%;
  background-color: #3ED71C ;
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  color: #fff;
  border: 2px solid #007bff;
  border-radius: 5px;
  cursor: pointer;
}
</style>
<body>
<div>
<div class="wrapper">
            <?php include("left.php");?>
            <div class="container">
            <div id="content">                            
		<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default"><br>
                        <center>
                    <h2>Employee Enrollment</h2>
                        </center><br>
						<div class="panel-body">
							<div class="row">
						 	<div class="col-lg-10">			
					    </div>	
<form name="onboardform" action="camaccess.php" method="GET">
								
    <script>
     function searchCname(searchValue) {
                var cnamelist = document.getElementById("cnamelist");
                cnamelist.innerHTML = "";
                if (searchValue.length > 0) {
                    <?php
                    $sqlcname = "SELECT eid, fname FROM `emp_details`";
                    $resultcname = mysqli_query($con, $sqlcname);
                    while ($row3 = mysqli_fetch_array($resultcname)) {
                        $oldString = urlencode($row3[1]);
                        $name=$oldString;
                        $pattern = '/[~!@#$%^&*()_ +}{|":;,<>?]/';
                        $encode = preg_replace($pattern, ' ', $oldString);
                        echo "if ('" . strtolower($encode) . "'.includes(searchValue.toLowerCase())) {";
                        echo "var option = document.createElement('option');";
                        echo "option.value = '" . $encode . "';";
                        echo "cnamelist.appendChild(option);";
                        echo "}";
                    }
                    ?>
                }
            }
            function SelectCname(selectedValue) {
                let jsnObj = <?php echo $jsonData1; ?>;
                let jsonname=jsnObj[selectedValue]['fname'];
                let jsoncid=jsnObj[selectedValue]['eid'];
                document.getElementById('empid').value = jsoncid;
            }
    </script>
                <div class="form-group">
                    <div class="row" style="margin-left: 5px;">
                     <div class="col-md-5">
                        
                            <label for="fn">Name <span style="font-size:11px;color:red">*</span></label>
                            <input type="text" class="form-control" style="font-size: 20px;" name="fn" id="fn" list="cnamelist" onkeyup="searchCname(this.value)" onchange="SelectCname(this.value)"><br>
                            <datalist id="cnamelist"></datalist>
                        </div>

                        <div class="col-md-3" >
                            <label for="empid">Employee ID<span style="font-size:11px;color:red">*</span></label>
                            <input type="text" class="form-control" style="font-size: 20px;" name="empid" id="empid" list="empid">
                        </div>
                        </div> 
                        <div  class="capdiv" style="margin-left: 22.5px;">
                        <input type="submit" value="Capture Images" class="btn-caputre">
                        <!--<input type="submit" id="strain" class="btn btn-primary" name="submit" onclick="starttrain()" value="Start Enroll" style="margin:2px 2px 5px 2px; width: 120px;">-->
                        </div>
                 </div>
        </form>
        </div>
       </div>
	  </div>								
	 </div>							
	</div>						
   </div></div>
        </div>
    </div>
    </div>
    <div>
    </div>
</body>

         <script src="assets/js/jquery-1.10.2.js"></script>
         <script src="assets/js/bootstrap.min.js"></script>
         <script src="vendors/datatables/datatables.min.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
             $('sams').on('click', function(){
                 $('makota').addClass('animated tada');
             });
         </script>
         <script type="text/javascript">

        //$(document).ready(function () {
 
        //    window.setTimeout(function() {
        //$("#sams1").fadeTo(1000, 0).slideUp(1000, function(){
        //$(this).remove(); 
        //});
            //}, 5000);
 
        //});
    </script>
         <script type="text/javascript">
             
             $(document).ready( function () {
                 $('#myTable').DataTable(({
                responsive: true,
                scrollX:"1500px",
                scrollY:"300px",
                scrollcolapse:"true",
                paging:"false",
        }));
    });
         </script>
</html>
<style>
    body {
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
    .container {
        max-width: 100%;
        overflow-x: hidden; 
        margin: 0; 
        padding: 0; 
    }
</style>
