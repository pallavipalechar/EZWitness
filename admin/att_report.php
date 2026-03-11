<?php
include("header.php");
require_once("database.php");
?>
<?php

    if (isset($_POST['btn_rpt'])) 
    {
        $re_month="";
        $re_year="";
        $sel_rpt=$_POST['sel_rpt'];
        $sel_rtype=$_POST['sel_rtype'];
        $sel_month=$_POST['sel_month'];
        $sel_year=$_POST['sel_year'];
        $fdate=$_POST['fdate'];
        $tdate=$_POST['tdate'];
        $shift_name=$_POST['shift_name'];

        if ($sel_month!="") 
        {
            header("location:pdf_month.php?month=$sel_month&rtype=$sel_rtype&rpt=$sel_rpt&year=$sel_year&shift=$shift_name");
        }else if ($sel_year!="") 
        {
            header("location:pdf_year.php?rtype=$sel_rpt&year=$sel_year&shift=$shift_name&rptjj=$sel_rtype");
        }
        else if ($fdate!="" && $tdate!="") 
        {
            
            header("location:pdf_date.php?fdate=$fdate&tdate=$tdate&rtype=$sel_rtype&rpt=$sel_rpt&shift=$shift_name");
        }
        else{
            echo "<script>alert('Please select Valid Data');</script>";
        }
        
    }

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
    </head>
    <body id="main_body">


<form method="POST" action="">  
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php include("left.php");?>
            <div class="container">
            <!-- Page Content Holder -->
            <div id="content">
        
            <div class="panel-heading" id="div_select"><br>
                <center>
                    <h2>Employee Attendance Details</h2>
                </center><br>
                <label>Report</label></br>
            
                <select id="sel_rpt" class="textfd" name="sel_rpt" onchange="sel_report()">
                    <option value="General">General</option>
                    <!--<option value="present">Present</option>-->
                    <!--<option value="absent">Absent</option>-->
                    <option value="late_come">Customized</option>
                    <!--<option value="early_going">Early Going</option>-->
                </select><br>
            


                <label>Report Type</label></br>
                <select id="sel_rtype" class="textfd" name="sel_rtype" onchange="sel_report()">
                    <option value="">---Select---</option>
                    <option value="monthly">Monthly</option>
                    <!-- <option value="yearly">Yearly</option> -->
                    <option value="Date">Daily</option><!-- 
                    <option value="department">Department</option> -->
                </select><br>
                <label class="labe_Change">Shift:</label><br>
                                <select name='shift_name' class="textfd">"
                                  <option value="all">All Shift</option>
                                    <?php $sqlshift = "select * from shift_details" ;
                                    $resultshift = mysqli_query($con, $sqlshift);
                                    while ($rowshift = mysqli_fetch_assoc($resultshift)) 
                                    {
                                        echo "<option value='".$rowshift['shift_name']."'>".$rowshift['shift_name']."</option>
                                        ";
                                    }
                                     ?>
                                </select><br>
                <label>Month</label></br>
                <select id="sel_month" class="textfd" name="sel_month" onchange="sel_report()">
                    <option value="">---Select---</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select><br>
                <label>Year</label></br>
                <select id="sel_year" class="textfd" name="sel_year" onchange="sel_report()">
                    <option value="">---Select---</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select></br>
                <label for="birthday">From</label></br>
                <input type="date"  class="textfdt" id="fdate" name="fdate">
                <br>
                <label for="birthday">To</label><br>
                <input type="date" class="textfdt" id="tdate" name="tdate">
                
                <center>
                <style>
#content {
    padding: 1px;
    min-height: auto;
    transition: all 0.3s;
    width:100%;
}
span.emp {
    text-align: center;
    font-size: 25px;
    font-weight: 700;
    font-family: inherit;
}
 .textfd{
  width: 80%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.textfdt{
  width: 80%;
  padding: 10px 15px;
  margin: 8px 10px;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 15px;
}
input[type=submit] {
  width: 22%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=button] {
  width: 15%;
  background-color: #4CAF50;
  color: white;
  padding: 15px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}

.form{
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

</style>

                    <div id="d1">
                        
                    </div>
        <script type="text/javascript">
            
            function sel_report(){
                        var r_type=document.getElementById('sel_rtype').value;
                        
                        if (r_type=="monthly") 
                        {
                            $('#sel_month').prop('disabled',false);

                            $('#fdate').prop('disabled',true);
                            $('#tdate').prop('disabled',true);
                            document.getElementById('fdate').value="";
                            document.getElementById('tdate').value="";
                            
                        }else if (r_type=="yearly") 
                        {
                            $('#sel_month').prop('disabled',true);
                            $('#sel_year').prop('disabled',false);
                            $('#fdate').prop('disabled',true);
                            $('#tdate').prop('disabled',true);
                            document.getElementById('fdate').value="";
                            document.getElementById('tdate').value="";

                            document.getElementById('sel_month').value="";
                        }else if (r_type=="Date") 
                        {
                            $('#sel_month').prop('disabled',true);
                            $('#sel_year').prop('disabled',true);
                            $('#fdate').prop('disabled',false);
                            $('#tdate').prop('disabled',false);

                            document.getElementById('sel_month').value="";
                        }
                        else{

                        }
                        
                    }
        </script>
        </center><br>
        <!--<input type="submit" name="btn_rpt" class="btn btn-primary" value="Download Report" style=" width: 150px;" > -->
        &nbsp;<button type="submit" name="btn_rpt" class="btn btn-primary" >Download Report</button>
        &nbsp;<button type="button" class="btn btn-primary" id="export_btn" >Export</button>
        
        <!-- <button><a href="convert_pdf/month_present_print.php?sel_month=<?php echo $sel_month; ?>">Generate PDF Report</a></button> -->
            </div></div></div></div>
           
            <script>
                    document.getElementById("export_btn").addEventListener("click", function() {
                        window.location.href = "att_export.php";
            });
            </script>

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

        $(document).ready(function () {
 
            window.setTimeout(function() {
        $("#sams1").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
        });
            }, 5000);
 
        });
    </script>
         <script type="text/javascript">
             $(document).ready( function () {
                 $('#myTable').DataTable({
                responsive: true,
                scrollX:"1500px",
                scrollY:"300px",
                scrollcolapse:"true",
                paging:"false",
        });
    });
         </script>
         </form>
         <script>
                document.addEventListener('DOMContentLoaded', function() {
                // Get today's date
                var today = new Date();

                // Format the date as yyyy-MM-dd (required format for HTML date input)
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;

                // Set the value of the date input field
                document.getElementById('fdate').value = today;
                document.getElementById('tdate').value = today;
                });
</script>
    </body>
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
