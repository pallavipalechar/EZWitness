<?php
include("header.php");
require_once("database.php");
$dt = $_POST['fdate'];


date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
// $tdate=date('d-m-Y');


?>

<!DOCTYPE html>
<html lang="en">
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

<link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Bootstrap core JavaScript-->
<script src="assets/js/jquery.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="assets/js/jquery.dataTables.min.js"></script>

<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">

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
    #content {

        padding: 1px;
        min-height: auto;
        transition: all 0.3s;
        width: 90%;
    }

    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 40%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 21px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 66%;
        margin-left: -158px;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
    }

    h2.center {
        text-align: center;
    }

    img {
        width: 45%;
    }

    center {
        margin-top: 49px;
    }

    hr {

        display: block;
        unicode-bidi: isolate;
        margin-block-start: 0.5em;
        margin-block-end: 0.5em;
        margin-inline-start: auto;
        margin-inline-end: auto;
        overflow: hidden;
        border-style: inset;
        border-width: 4px;
        text-decoration-color: black;
    }

    span.att {
        font-weight: 600;
        font-size: 18px;
    }

    span.dep {
        font-size: 18px;
        font-weight: 600;
    }

    .split-para {
        display: block;
        margin: 10px;
        font-size: 18px;
    }

    .split-para span {
        display: block;
        float: right;
        width: 19%;
        margin-left: 10px;
    }
</style>

<body>
    <form method="POST" action="#">
        <div class="wrapper">

            <?php include("left.php"); ?>
            <div class="container">
            <div id="content">
                <center>
                    <h2 class="center">Unknown Log </h2>
                    <a><?php echo $dt ?></a>

                    <br>
                    <div class="font">

                        <br></br>
                        <table class="table table-bordered" id="datatable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th>SI Number</th>
                                    <th>Image</th>
                                    <th>Date & Time</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                // $s=date('Y-m-d');
                                // echo $s;

                                $dir_name = "../python/log_unknownimg/$dt";
                                $file = scandir($dir_name);
                                $i = 0;
                                $j = 1;
                                $totalfiles = count($file);


                                while ($i < $totalfiles) {

                                    $f = $file[$i];

                                    $sf = explode("_", $f);
                                    // echo sizeof($sf);
                                    if (sizeof($sf) == 3) {
										$timeWithoutExtension = pathinfo($sf[2], PATHINFO_FILENAME);
                                      	$timePart = explode("-", $timeWithoutExtension);
                                        $time = $timePart[0] . ":" . $timePart[1] . ":" . $timePart[2];
                                        if ($file == true) {
                                ?>
                                            <tr>
                                                <td><?php echo $j++ ?></td>
                                                <td><img src="<?php echo $dir_name . "/" . $f ?>" style="height:100px;width:100px"> </td>
                                                <td><?php echo  $time; ?></td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    $i++;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
            </div></div></div>
            <script>
                $(function() {
                    'use strict';

                    $('#datatable1').DataTable({
                        responsive: true,
                        language: {
                            searchPlaceholder: 'Search...',
                            sSearch: '',
                            lengthMenu: '_MENU_ items/page',
                        }
                    });

                    $('#datatable2').DataTable({
                        bLengthChange: false,
                        searching: false,
                        responsive: true
                    });

                    // Select2
                    // $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

                });
            </script>
           <script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
    $('sams').on('click', function () {
        $('makota').addClass('animated tada');
    });
</script>
            <style>
                .font {
                    font-size: 2pc;
                }
            </style>
    </form>
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
