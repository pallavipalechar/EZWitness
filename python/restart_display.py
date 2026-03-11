
import os
import time
from datetime import datetime
while(True):
        try:
                time_now = datetime.now()
                current_time = time_now.strftime("%H:%M:%S")
                end_time = str(current_time)
                f1 = open("/opt/lampp/htdocs/ez/python/img_only.txt", "r")
                start_time1=str(f1.readline())
                f1.close()
                start_time1 = start_time1.replace('\n', '').replace('\r', '')
                t11 = datetime.strptime(start_time1, "%H:%M:%S")
                t12 = datetime.strptime(end_time, "%H:%M:%S")
                delta1 = t12 - t11
                sc1=delta1.total_seconds()
                print(sc1)
                if sc1>60:
                        print("Restart Dection")
                        os.system("python3 /opt/lampp/htdocs/ez/python/img_detection.py &")
                      
        except Exception as e: 
                print(e)
                continue
        time.sleep(60)

