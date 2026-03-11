<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>

          <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
         <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
       <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/awesome/font-awesome.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        
    </head>
    <style>
    input.button {
        background-color: red;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius:10px;
        padding: 10px;
    
}
    </style>
    <body>
    <form action="" method="POST" enctype="multipart/form-data">
    	
 <div class="wrapper">

           <?php include("left.php");?>
                
        <div class="line"></div>
                                   
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Holiday Management</h3>
            </div>
                <div class="panel-body">  
                <center><a href="gen_holyday/gen_holiday.php"><input type="text" class="button" name="btn_hday" value="Genral Holiday"></a>
                    <a href="weekoff/we_holiday.php"> <input type="text"  class="button" name="btn_hday" value="Week Off"></a></center>
                </div>
            </div>
        </div>        
</div>

        <!-- jQuery CDN -->
         <script src="assets/js/jquery-1.10.2.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="assets/js/bootstrap.min.js"></script>

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
         </form>
    </body>
</html>
