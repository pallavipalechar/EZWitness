<?php
$pickleFilePath = '/opt/lampp/htdocs/ez/python/database_bw/representations_facenet512.pkl';
$response = file_exists($pickleFilePath) ? 'found' : 'not_found';
echo $response;
?>