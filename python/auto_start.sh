#!/bin/bash
python3 /opt/lampp/htdocs/ez/python/image_detection.py &
sh /home/manipal/campic121/moveimg.sh
sleep 2
#wmctrl -r "OUTface" -b toggle,above
python3 /opt/lampp/htdocs/ez/python/img_recognition.py  &
python3 /opt/lampp/htdocs/ez/python/file_monitor_create.py  
python3 /opt/lampp/htdocs/ez/python/file_monitor_delete.py 
python3 /opt/lampp/htdocs/ez/python/watch_pklFile.py  
#sleep 30
#python3 /opt/lampp/htdocs/ez/python/restart_display.py &
