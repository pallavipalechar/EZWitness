<?php
// Read the properties file
$properties = parse_ini_file('/opt/lampp/htdocs/ez/python/fr_allconfig/ipconfig_file.properties');

// Access the variables
$email_sub = $properties['email_sub'];
$email_body = $properties['email_body'];
$from_name = $properties['from_name'];

// Now you can use these variables in your code
echo $email_sub;
echo $email_body;
echo $from_name;
?>