import sys
from deepface import DeepFace
import cv2
import os
import requests
# python3 log_filter.py
database="/opt/lampp/htdocs/ez/python/database_bw"
i=0
rec=''
result =  os.listdir('/opt/lampp/htdocs/ez/python/filter_log')
for filename in result:
	f = open("/opt/lampp/htdocs/ez/python/filter_log/"+filename, "r")
	data=f.read()
	f.close()
	newdata= data.rstrip("~")
	arr = newdata.split("~")
	fsize=len(arr)-1
	d=newdata.split(",")
	emp_id=d[0]
	img_path=d[4]
	print(img_path)
	face="/opt/lampp/htdocs/ez/ez/cap_img/"+img_path
	print(face)
	df = DeepFace.find(img_path = face,db_path = database,  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
	df=df[0]
	print(df)
	
	if df.empty:
		print("DataFrame is empty")
		os.remove("/opt/lampp/htdocs/ez/python/filter_log/"+filename)
		continue
	my_dict = {}
	
	for i in range(len(df)):
		#print(df.iloc[:,0][i])
		im=df.iloc[:,0][i].split("/")
		db_img=im[-1]
		de=db_img.split("_")
		eid=de[0]
		#print(eid)
		
		
		if eid in my_dict:
			my_dict[eid] += 1
		else:
			my_dict[eid] = 1
	print(my_dict)
	max_key = max(my_dict, key=my_dict.get)
	print("-------------------------------")
	print(max_key)
	if emp_id==max_key:
		r = requests.post('http://localhost/ez/admin/py_synk_data.php', data={'ins_data': data})
		print(r.text)
		rec=r.text
	else:
		r1 = requests.post('http://localhost/ez/admin/py_synk_crossdata.php', data={'ins_data': data})
		print(r1.text)
		rec=r1.text
	if(rec=='delete'):
		os.remove("/opt/lampp/htdocs/ez/python/filter_log/"+filename)	
		
		
		
