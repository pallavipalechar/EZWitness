<!DOCTYPE html>
<html>
<!-- <?php
// session_start();
?> -->
<head>

</head>
<body>

 <link rel="stylesheet" href="assets/css/all.css">
 <style>
 .img-thumbnail {
  display: inline-block;
  max-width: 75%;
  height: auto;
  padding: 4px;
  line-height: 1.42857143;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-transition: all .2s ease-in-out;
  -o-transition: all .2s ease-in-out;
  transition: all .2s ease-in-out;
}
.logo{
    text-align: center;
    padding: 2% 2% 0% 0%;
}
 </style>
 <nav id="sidebar" class="sammacmedia">
   
                <div style="position:fixied; padding:10% 0% 0% 0%" class="sidebar-header">
                    <h3 class="logo"> <img src="../images/EZ_Witness-logos_black-removebg-preview.png" style="width: 63%;"></h3>
                    <strong> <i class="fa fa-spinner fa-2x"></i></strong>
                </div>

                <ul class="list-unstyled components" style="padding:5% 0% 0% 0%">
                    <li >
                        <a href="dashboard.php">
                            <i class="fa fa-dashboard fa-2x"></i>
                           &nbsp;Dashboard
                        </a>
                    </li>
                
                    <li>
                        <a href="onboard.php">
                            <i class="fa fa-camera  fa-2x"></i>
                            &nbsp;Employee Enrollment
                        </a>
                      
                    </li>

                 
                    <li>
                        <a href="view.php"><i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;&nbsp; Manage Employees</a>
                                                                 
                    </li>
                    
                    
                   <?php
                   //if($_SESSION['role']=='MA')
                   {
                   ?>
                   <li>
                      <a href="log_attdata.php"><i class="fa fa-calendar fa-2x"></i>&nbsp;&nbsp;  Attendance Log</a>
                    </li>
                   <li>
                    <a href="unknown_log.php"><i class="fa fa-question-circle fa-2x"></i>&nbsp;&nbsp;  Unknown Log</a>
                    </li>
                   <?php 
                   }
                   ?>

                    <li>
                      <!--  <a href="ftreport.php"><i class="fas fa-chart-line fa-2x"></i>&nbsp;&nbsp;Attendance Report</a>-->

                    </li>
                     <li>
                        <a href="att_report.php"><i class="fa fa-folder-open fa-2x"></i>&nbsp;&nbsp;Attendance Report</a>
			
                    </li>
                    <!-- <li>
                        <a href="regenerate_report.php"><i class="fa fa-file fa-2x"></i>&nbsp;&nbsp; Regenerte Report</a>
			
                    </li>-->
                  <li>
                       <a href="shift_assign.php"><i class="fa fa-info fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Shift Assign</a>
                    </li>
                    <li>
                       <a href="shift_details.php"><i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;Shift Details</a>
                    </li>
                    
                    <li>
                     <a href="settings.php"><i class="fa fa-cog fa-2x"></i>&nbsp;&nbsp; Settings</a>
                    </li> 
                  	<li>
                     <a href="update_mail_contents.php"><i class="fa fa-envelope fa-2x"></i>&nbsp;&nbsp; Update Email Contents</a>
                    </li> 
                     
                    <li>
                     <a href="refreshdb.php"><i class="fa fa-refresh fa-2x"></i>&nbsp;&nbsp; Refresh Database</a>
                    </li> 

					<li>
                     <a href="logout.php"><i class="fa fa-times fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;Logout</a>
                    </li>
                </ul>
            </nav>
            <div id="content" style="width:overflow;">
                 <div style="background-color: black;width:120%;height:120px;color: white;text-align:left;text-decoration: calibri;font-size: 35px;" class="sidebar animated"><h1 align="center" style="font-size: 50px"> </h1>

                <nav class="navbar  sammacmedia">
                    <div class="container-fluid">

                        <div class="navbar-header" id="sams">
                            <button type="button" id="sidebarCollapse" id="makota" class="btn btn-sam animated  navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span>Menu</span>
                            </button>
                        </div>
						
						
						
                </nav>

               </div>
	</body>
</html>