<?php
include("header.php");
require_once("database.php");

function updateConfigFile($old_config_file, $new_config_data) {

  if (file_exists($old_config_file)) {
        unlink($old_config_file);
    }

    $file_handle = fopen($old_config_file, 'w');

    if ($file_handle === false) {
        echo "Error creating file.";
        return;
    }

    foreach ($new_config_data as $key => $value) {
        fwrite($file_handle, $key . "=" . $value . PHP_EOL);
    }

    fclose($file_handle);

    chmod($old_config_file, 0777);
}

$new_config_file = "/opt/lampp/htdocs/ez/python/fr_allconfig/ipconfig_file.properties";

$config_data = array(); 
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and populate config_data array
    $config_data['rtsp_url_cam'] = $_POST["rtsp_url_cam"];
    $config_data['database'] = $_POST["database"];
    $config_data['database_bw'] = $_POST["database_bw"];
    $config_data['localsite'] = $_POST["localsite"];
    $config_data['detected_img'] = $_POST["detected_img"];
    $config_data['log_data'] = $_POST["log_data"];
    $config_data['main_display_img'] = $_POST["main_display_img"];
  
    $config_data['log_unimg'] = $_POST["log_unimg"];
    $config_data['startimgpath'] = $_POST["startimgpath"];
    $config_data['font_2fr'] = $_POST["font_2fr"];
    $config_data['font_3fr'] = $_POST["font_3fr"];
    $config_data['font_fr'] = $_POST["font_fr"];
    $config_data['xml_file'] = $_POST["xml_file"];
    $config_data['detector_name'] = $_POST["detector_name"];
  
     $config_data['detector_name_train'] = $_POST["detector_name_train"];
    $config_data['pkl_file'] = $_POST["pkl_file"];
    $config_data['in_port'] = $_POST["in_port"];
    $config_data['in_ip'] = $_POST["in_ip"];
    $config_data['out_port'] = $_POST["out_port"];
    $config_data['out_ip'] = $_POST["out_ip"];

    updateConfigFile($new_config_file, $config_data);

    $success_message = "<p>Camera details updated successfully!</p>";

    // Refresh the page after updating the config file
    header("Refresh:0");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Change Camera IP Address</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/awesome/font-awesome.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php include("left.php");?>

            <!-- Page Content Holder -->
            <div id="content">
                <div class="line"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Camera</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <!-- Form for updating IP address -->
                                        <div class="form-group">
                                            <label for="rtsp_url_cam">RTSP URL Camera:</label>
                                            <input type="text" id="rtsp_url_cam" name="rtsp_url_cam" class="form-control" value="<?php echo isset($config_data['rtsp_url_cam']) ? $config_data['rtsp_url_cam'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="database">Database:</label>
                                            <input type="text" id="database" name="database" class="form-control" value="<?php echo isset($config_data['database']) ? $config_data['database'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="database_bw">Database BW:</label>
                                            <input type="text" id="database_bw" name="database_bw" class="form-control" value="<?php echo isset($config_data['database_bw']) ? $config_data['database_bw'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="localsite">Local Site:</label>
                                            <input type="text" id="localsite" name="localsite" class="form-control" value="<?php echo isset($config_data['localsite']) ? $config_data['localsite'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="detected_img">Detected Image:</label>
                                            <input type="text" id="detected_img" name="detected_img" class="form-control" value="<?php echo isset($config_data['detected_img']) ? $config_data['detected_img'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="log_data">Log Data:</label>
                                            <input type="text" id="log_data" name="log_data" class="form-control" value="<?php echo isset($config_data['log_data']) ? $config_data['log_data'] : ''; ?>">
                                        </div>
                                      <div class="form-group">
                                            <label for="log_unimg">log_unimg:</label>
                                            <input type="text" id="log_unimg" name="log_unimg" class="form-control" value="<?php echo isset($config_data['log_unimg']) ? $config_data['log_unimg'] : ''; ?>">
                                        </div>
                                      <div class="form-group">
                                            <label for="startimgpath">log_unimg:</label>
                                            <input type="text" id="startimgpath" name="startimgpath" class="form-control" value="<?php echo isset($config_data['startimgpath']) ? $config_data['startimgpath'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="main_display_img">Main Display Image:</label>
                                            <input type="text" id="main_display_img" name="main_display_img" class="form-control" value="<?php echo isset($config_data['main_display_img']) ? $config_data['main_display_img'] : ''; ?>">
                                        </div>
                                      
                                      	<div class="form-group">
                                            <label for="font_2fr">font_2fr:</label>
                                            <input type="text" id="font_2fr" name="font_2fr" class="form-control" value="<?php echo isset($config_data['font_2fr']) ? $config_data['font_2fr'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="font_3fr">font_3fr:</label>
                                            <input type="text" id="font_3fr" name="font_3fr" class="form-control" value="<?php echo isset($config_data['font_3fr']) ? $config_data['font_3fr'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="font_fr">font_fr:</label>
                                            <input type="text" id="font_fr" name="font_fr" class="form-control" value="<?php echo isset($config_data['font_fr']) ? $config_data['font_fr'] : ''; ?>">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="xml_file">xml_file:</label>
                                            <input type="text" id="xml_file" name="xml_file" class="form-control" value="<?php echo isset($config_data['xml_file']) ? $config_data['xml_file'] : ''; ?>">
                                        </div>
                                      
                                       <div class="form-group">
                                            <label for="detector_name">detector_name:</label>
                                            <input type="text" id="detector_name" name="detector_name" class="form-control" value="<?php echo isset($config_data['detector_name']) ? $config_data['detector_name'] : ''; ?>">
                                        </div>
                                      <div class="form-group">
                                            <label for="detector_name_train">detector_name_train:</label>
                                            <input type="text" id="detector_name_train" name="detector_name_train" class="form-control" value="<?php echo isset($config_data['detector_name_train']) ? $config_data['detector_name_train'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pkl_file">pkl_file:</label>
                                            <input type="text" id="pkl_file" name="pkl_file" class="form-control" value="<?php echo isset($config_data['pkl_file']) ? $config_data['pkl_file'] : ''; ?>">
                                        </div>
                                      
                                      <div class="form-group">
                                            <label for="in_port">in_port:</label>
                                            <input type="text" id="in_port" name="in_port" class="form-control" value="<?php echo isset($config_data['in_port']) ? $config_data['in_port'] : ''; ?>">
                                        </div>
                                      
                                      <div class="form-group">
                                            <label for="in_ip">in_ip:</label>
                                            <input type="text" id="in_ip" name="in_ip" class="form-control" value="<?php echo isset($config_data['in_ip']) ? $config_data['in_ip'] : ''; ?>">
                                        </div>
                                      <div class="form-group">
                                            <label for="out_port">out_port:</label>
                                            <input type="text" id="out_port" name="out_port" class="form-control" value="<?php echo isset($config_data['out_port']) ? $config_data['out_port'] : ''; ?>">
                                        </div>
                                      
                                      <div class="form-group">
                                            <label for="out_ip">out_ip:</label>
                                            <input type="text" id="out_ip" name="out_ip" class="form-control" value="<?php echo isset($config_data['out_ip']) ? $config_data['out_ip'] : ''; ?>">
                                        </div>
                                        
                                      
                                        <div class="form-group">
                                            <label for="in_screen_name">in_screen_name:</label>
                                            <input type="text" id="in_screen_name" name="in_screen_name" class="form-control" value="<?php echo isset($config_data['in_screen_name']) ? $config_data['in_screen_name'] : ''; ?>">
                                        </div>
                                      
                                        <div class="form-group">
                                            <label for="out_screen_name">out_screen_name:</label>
                                            <input type="text" id="out_screen_name" name="out_screen_name" class="form-control" value="<?php echo isset($config_data['out_screen_name']) ? $config_data['out_screen_name'] : ''; ?>">
                                        </div>
                                      
                                      
                                        <button type="submit" class="btn btn-primary" name="update_ip" onclick="return confirmUpdate()">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            $('#myTable').DataTable(({
                responsive: true,
                scrollX:"1500px",
                scrollY:"300px",
                scrollcolapse:"true",
                paging:"false",
            });
        });
    </script>
  <script>
    function confirmUpdate() {
        var confirmMessage = "Are you sure? It will affect the entire workflow.";
        if (confirm(confirmMessage)) {
            return true;
        } else {
            return false;
        }
    }
</script>
</body>
</html>