#!/bin/bash

#php_file_path="ez/admin/send_in_out_notification.php"
#browser="xdg-open"  # Command to open the default web browser

# Assuming PHP files are served by a local web server at http://localhost/
#url="http://localhost/$php_file_path"


# Open the URL in the default web browser
#$browser "$url"

wget -q -O /dev/null http://localhost/ez/admin/send_in_out_notification.php &