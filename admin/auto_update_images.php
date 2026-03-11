<?php
include("database.php");
$today=date('Y-m-d');
$from=date('Y-m-d',strtotime($today."-6 days"));
$query = "SELECT DISTINCT eid FROM gen_attendance";
$result = $con->query($query);

while ($row = $result->fetch_assoc()) {
    $eid = $row['eid'];
    $queryImages = "SELECT cap_image, ename,acc_rate FROM gen_attendance 
                    WHERE eid = '$eid' AND acc_rate < 0.18 and gdate>='$from' and gdate<='$today'
                    ORDER BY acc_rate
                    LIMIT 15";

    $resultImages = $con->query($queryImages);
    $databaseFolder = "../python/database_bw";
    if (!is_dir($databaseFolder)) {
        mkdir($databaseFolder);
    }

    $imgno=6;
    while ($imageRow = $resultImages->fetch_assoc()) {
      $emp_name = $imageRow['ename'];
      $cap_image = $imageRow['cap_image'];
        $imagePath = "$databaseFolder/{$eid}_{$emp_name}_{$imgno}.jpg";
        $copy_path="./cap_img".$cap_image;
        copy($copy_path, $imagePath); 
        $imgno++; 
    }   
}
$con->close();

#pickle creation
$pickle_rep_path="../python/database_bw/representations_facenet512.pkl";
$pickle_text_path="../python/pickle/pickle_Exists.txt";
unlink($pickle_rep_path);
unlink($pickle_text_path);


?>