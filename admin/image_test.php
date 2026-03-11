<?php

$dir_path = "images/";

$extensions_array = array('jpg','png','jpeg');

if(is_dir($dir_path))

{
    $files = scandir($dir_path);
    
    for($i = 0; $i < count($files); $i++)
    {
        if($files[$i] !='.' && $files[$i] !='..')
        {
            $file = pathinfo($files[$i]);
            $extension = $file['extension'];
            if(in_array($extension, $extensions_array))
            {
            echo "<img src='$dir_path$files[$i]' style='width:100px;height:100px;margin-left:10px'>";
            }
        }
    }
}