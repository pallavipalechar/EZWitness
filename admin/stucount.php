<?php
 require_once("database.php");
    $fdate=$_GET['cdate'];
    $sdname='';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Page level plugin JavaScript--><script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
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
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 40%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 21px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}
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
  background-color: ;
  color: ;
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
hr{
    
    display: block;
    unicode-bidi: isolate;
    margin-block-start: 0.5em;
    margin-block-end: 0.5em;
    margin-inline-start: auto;
    margin-inline-end: auto;
    overflow: hidden;
    border-style: inset;
    border-width: 4px;
    webkit-text-decoration-color: black; /* Safari */  
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
.split-para      { display:block;margin:10px;font-size: 18px;}
.split-para span { display:block;float:right;width:19%;margin-left:10px;}
</style>
<body>
<?php
function getBetweenDates($startDate, $endDate)
{
    $rangArray = [];

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for (
        $currentDate = $startDate;
        $currentDate <= $endDate;
        $currentDate += (86400)
    ) {

        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}
$dates = getBetweenDates($fdate, $tdate);
?>
  
    <form method="POST" action="#">
<div class="wrapper">
            <!-- Sidebar Holder -->
        <?php include("left.php");?>
            <!-- Page Content Holder -->
            <div id="content">
<center>
<h2 class="center">Student Count</h2>

<p style="color: black"><b>Date: <?php echo $fdate;?>
</b>
</p>
<br>
<div>
    <!-- <label>Employee ID:</label>
    <input type="text" name="txt_eid">
    <button name="search">Search</button> -->
    <br>
    <style type="text/css">
        .button {
  background-color: #f44336; 
  position: relative;
  left: -559px;
  border: none;
  color: white;
  padding: 14px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 3px 1px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius: 10px;
}
    </style>
</div>
<!-- <input type="submit" name="gen_att" id="gen_att" value="Generate Attendance"> -->
<br></br>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <th>Date</th>
      <th>Total Count</th>
      <th>In-Count</th>
      <th>OUt-Count</th>
    </thead>
    <tbody>
      <?php
      $icount=1;
      $camidcount=0;
      $camidin=0;
      $stucount=0;
      $seldae="SELECT * FROM `emp_details`";
      echo "<tr>";
      echo '<td>'.$fdate.'</td>';
        $sresult = mysqli_query($con, $seldae);
        while ($row = mysqli_fetch_array($sresult)) 
        {
          
          $eid=$row['eid'];
          $ename=$row['fname'];
          $stucount=$stucount+1;
          $seldae2="SELECT * FROM `gen_attendance` WHERE `eid`='$eid'and `gdate`='$fdate' order by `id` desc LIMIT 1";
          $sresult2 = mysqli_query($con, $seldae2);
          $row2 = mysqli_fetch_array($sresult2);
          $camid=$row2['cam_id'];
          if ($camid=='cam1') 
          {
            $camidcount=$camidcount+1;
          }
          if ($camid=='cam2') {
            $camidin=$camidin+1;
          }
          
        }
        echo '<td>'.$stucount.'</td>';
        echo '<td><a href="sdisplay.php?date='.$fdate.'&cam=cam1">'.$camidcount.'</td>';
        echo '<td><a href="sdisplay.php?date='.$fdate.'&cam=cam2">'.$camidin.'</td>';
        echo "</tr>";
      ?>
    </tbody>
  </table>
</center>
                                    </div>
                                </div>
                                <script>
                                $(function () {
                                    $('#dataTable').DataTable({
                                      "pageLength": 10,
                                      "paging": true,
                                      "lengthChange": false,
                                      "searching": false,
                                      "ordering": true,
                                      "info": true,
                                      "autoWidth": false
                                      });
                                  });
                                </script> 
                                </form>
                                </body>
                                </html>


