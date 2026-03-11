import os
import time
from datetime import datetime
if(True):
	try:
		time_now = datetime.now()
		current_time = time_now.strftime("%H:%M:%S")
		end_time = str(current_time)
		
		#To read the time from img_only and compare with current time
		f2 = open("/opt/lampp/htdocs/ez/python/img_only.txt", "r") 
		start_time2=str(f2.readline())
		f2.close()
		start_time2 = start_time2.replace('\n', '').replace('\r', '')
		t21 = datetime.strptime(start_time2, "%H:%M:%S")
		t22 = datetime.strptime(end_time, "%H:%M:%S")
		delta2 = t22 - t21
		sc2=delta2.total_seconds()
		
		#To read time from the img_recogniition.txt and comare with current time
		f3 = open("/opt/lampp/htdocs/ez/python/img_recognition.txt", "r")
		start_time3=str(f3.readline())
		f3.close()
		start_time3 = start_time3.replace('\n', '').replace('\r', '')
		t21 = datetime.strptime(start_time3, "%H:%M:%S")
		t22 = datetime.strptime(end_time, "%H:%M:%S")
		delta2 = t22 - t21
		sc3=delta2.total_seconds()
	
		if sc2>10:
			print("Restart Detection")
			os.system("python3 /opt/lampp/htdocs/ez/python/img_detection.py &")
			#os.system("python3 /opt/lampp/htdocs/ez/IPCam_img_detection.py &")
		if sc3>20:
			print("Restart Recognition")
			os.system("python3 /opt/lampp/htdocs/ez/python/img_recognition.py &")
	except Exception as e: 
		print(e)
		#continue
	time.sleep(10)
