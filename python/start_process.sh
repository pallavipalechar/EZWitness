
cd /opt/lampp/htdocs/ez/python/
pkill -f DISPLAY_image.py &
pkill -f IPCam_img_detection.py &
pkill -f img_recognition.py &
pkill -f restart.py &
sleep 0.1
python3 onboard.py &

