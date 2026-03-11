<?php
include("header.php");
require_once("database.php");

function updateMailContent($emailSubject, $emailBody, $fromName) {
    $filePath = "/opt/lampp/htdocs/ez/python/fr_allconfig/mail_content.txt";
    
    // Construct the new content with values enclosed in double quotes
    $newContent = "email_sub = \"$emailSubject\"\n";
    $newContent .= "email_body = \"$emailBody\"\n";
    $newContent .= "from_name = \"$fromName\"\n";

    // Write the new content to the file
    file_put_contents($filePath, $newContent);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailSubject = $_POST['email_subject'];
    $emailBody = $_POST['email_body'];
    $fromName = $_POST['from_name'];
    updateMailContent($emailSubject, $emailBody, $fromName);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Notification for the day</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/awesome/font-awesome.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
</head>
<body>
    <form action="" method="post">
        <div class="wrapper">
            <?php include("left.php"); ?>
            <div class="container">
            <div id="content">
                <div class="panel panel-default">
                    <br><center><h2>Notification for Employees</h2></center><br>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label for="email_subject">Email Subject</label>
                                    <input type="text" id="email_subject" name="email_subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email_body">Email Body</label>
                                    <textarea id="email_body" name="email_body" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="from_name">From Name</label>
                                    <input type="text" id="from_name" name="from_name" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
    </form>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="vendors/datatables/datatables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        $(document).ready(function () {
            window.setTimeout(function() {
                $("#sams1").fadeTo(1000, 0).slideUp(1000, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
        $(document).ready(function () {
            $('#myTable').DataTable({
                responsive: true,
                scrollX: "1500px",
                scrollY: "300px",
                scrollCollapse: true,
                paging: false,
            });
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
