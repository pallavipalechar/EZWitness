<?php
 echo "start of file";
    $respresntation_pkl = '/opt/lampp/htdocs/ez/python/database_bw/representations_facenet512.pkl';
    $pickle_txt='/opt/lampp/htdocs/ez/python/pickle/pickle_Exists.txt';
    if (unlink($respresntation_pkl)) {
          echo"deleted pickle";
      }
      if(!file_exists($pickle_txt))
      {
      echo"nnnn";
      $f=fopen('/opt/lampp/htdocs/ez/python/pickle/pickle_Exists.txt', 'w');
      }
       if (unlink($pickle_txt)) 
        {
          echo"deleted pickleeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
       }


  header('Location:refreshdb.php');
 //$filepath = '/opt/lampp/htdocs/ez/python/watchdog/start_onboard.txt';
 //$file = fopen($filepath, 'w');

//if ($file) {
  //write($file, '`starttrain()`');
  //fclose($file);
//} else {
  //// Error opening the file
 //echo 'Error opening the file!';

//}//

?>