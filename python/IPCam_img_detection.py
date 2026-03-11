from deepface import DeepFace
from retinaface import RetinaFace
import matplotlib.pyplot as plt
import cv2
import numpy as np
import glob, os
import time
from datetime import date
from datetime import datetime
import datetime as dt
#import imutils
from PIL import ImageFont, ImageDraw, Image
import random
import uuid
import threading, queue
import subprocess
import sys
#import keyboard
from deepface.detectors import FaceDetector
import threading
import socket
from jproperties import Properties
import mediapipe as mp
from mediapipe.python.solutions.drawing_utils import _normalized_to_pixel_coordinates

mp_face = mp.solutions.face_detection.FaceDetection(
    model_selection=1, # model selection 0-zoomed in, 1-zoomed out
    min_detection_confidence=0.5 # confidence threshold
)
mp_face_mesh = mp.solutions.face_mesh
face_mesh = mp_face_mesh.FaceMesh(min_detection_confidence=0.5, min_tracking_confidence=0.5)
configs = Properties()
mp_face_detection = mp.solutions.face_detection

multi_win=0
with open('/var/www/html/ez/python/fr_allconfig/EZWitness_config.properties', 'rb') as read_prop:
    configs.load(read_prop)
#rtsp_url=configs.get("rtsp_url_cam1").data
rtsp_url=configs.get("mainofficecamrtsp_url_cam1").data
database=configs.get("database").data
database_bw=configs.get("database_bw").data
localsite=configs.get("localsite").data
detected_img=configs.get("detected_img").data
startimgpath=configs.get("startimgpath").data
log_data=configs.get("log_data").data
log_unimg=configs.get("log_unimg").data
#message=configs.get("message_cam1").data
cam_name=configs.get("cam1_name").data
scr=configs.get("cam1_screen").data
main_display_img=configs.get("main_display_img").data
font_2fr=configs.get("font_2fr").data
font_fr=configs.get("font_fr").data
xml_file=configs.get("xml_file").data
detector_name = configs.get("detector_name").data
in_ip= configs.get("in_ip").data
in_port= configs.get("in_port").data
training_txt=configs.get("training_txt").data
training_img=configs.get("training_img").data  
l_count=0
#path="/var/www/html/ez/python/database_bw/"
start_face=os.listdir(startimgpath)[0]
try:
   df = DeepFace.find(img_path = start_face,db_path = "./database_bw",  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
   print("----------------------------------------------")
except Exception as e:
   print("Existssssssssssssssssssssssssssssssssss")

class VideoCapture:

  def __init__(self, name):
    self.cap = cv2.VideoCapture(name,cv2.CAP_FFMPEG)
    print(self.cap)
    if(self.cap.isOpened()):
      self.q = queue.Queue()
      t = threading.Thread(target=self._reader)
      t.daemon = True
      t.start()
    else:
      print("Alert ! Camera disconnected")    

  def _reader(self):
    global err_msg
    while True:
      ret, frame = self.cap.read()
      if not ret:
        print("cam is not running")
        err_msg=1
        break
        
      if not self.q.empty():
        try:
          self.q.get_nowait()   # discard previous (unprocessed) frame
        except queue.Empty:
          pass
      self.q.put(frame)

  def read(self):
    return self.q.get()

start_time = time.time()
reg_name=''
video_cap = VideoCapture(rtsp_url)
c=0
new_image='';
fcount=0
i=1
yax=120
dount=0
name_list=[]
dup_name=''
active=0
dup_count=0
dis_count=0
rad = uuid.uuid1()
font=''
global err_msg
err_msg=0
status='A'
p=1
train_fcount=1
database_2=database
onboard_file=False
unknown_count=0
shashank = 1
numcheck = 1
prevName=''

while(True):  
    time.sleep(0.1)
    shashank = shashank + 1
    print(shashank)
    dis_count=dis_count+1
    time_now = datetime.now()
    date_time = time_now.strftime("%d/%m/%Y, %I:%M:%S %p")
    current_time = time_now.strftime("%H:%M:%S")
    f = open("/var/www/html/ez/python/img_only.txt", "w")
    f.write(str(current_time))
    f.close()

    if err_msg==1:
        print('err inside'+str(err_msg))
        err_msg = 0;
        continue
    frame = video_cap.read()
    if numcheck < 3:
        
        numcheck = numcheck + 1
        continue
    numcheck = 1
    
    image_rows, image_cols, _ = frame.shape
    # image_input=frame
    image_input = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    # dount=dount+1
    results = mp_face.process(image_input)
    # if(True):
    # 	if (len(name_list)>0):
    #     	clientSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    #     	clientSocket.connect((in_ip,int(in_port)))
    #     	clientSocket.send('delete'.encode())
    #     	clientSocket.close()
    #     	# dount=0
    #     	i=1
    #     	l_count=0
    #     	reg_name=''
    #     	l_count=len(name_list)
    #     	# if status != 'T':
    #     	del name_list[0]
    #     	# time.sleep(1)
    	
    # 	# time.sleep(0.1)
    if not results.detections: 
    	continue
    
    if 1 == 2:
        print("Nothing in the frame")
        continue;
    else:
        
        face_3d = []
        face_2d = []
        text = ""
        img = frame
        pre_face=frame
        for detection in results.detections:
          print("@@@@@@@@@@@@@@@@@@@")
          eye_left=mp_face_detection.get_key_point(detection, mp_face_detection.FaceKeyPoint.LEFT_EYE)
          print("Left",eye_left)
          eye_right=mp_face_detection.get_key_point(detection, mp_face_detection.FaceKeyPoint.RIGHT_EYE)
          print("Right",eye_right)
          location = detection.location_data
          relative_bounding_box = location.relative_bounding_box
          rect_start_point = _normalized_to_pixel_coordinates(
              relative_bounding_box.xmin, relative_bounding_box.ymin, image_cols,
              image_rows)
          rect_end_point = _normalized_to_pixel_coordinates(
              relative_bounding_box.xmin + relative_bounding_box.width,
              relative_bounding_box.ymin + relative_bounding_box.height, image_cols,
              image_rows)
          try:
            xleft,ytop=rect_start_point
            xright,ybot=rect_end_point

            face = image_input[ytop: ybot, xleft: xright]
            img_h, img_w, img_c = face.shape
            results1 = face_mesh.process(face)
            window_name = 'image'

            if results1.multi_face_landmarks:
                print("face")
                for face_landmarks in results1.multi_face_landmarks:
                    for idx, lm in enumerate(face_landmarks.landmark):
                        if idx == 33 or idx == 263 or idx == 1 or idx == 61 or idx == 291 or idx == 199:
                            if idx == 1:
                              nose_2d = (lm.x * img_w, lm.y * img_h)
                              nose_3d = (lm.x * img_w, lm.y * img_h, lm.z * 8000)
                        x, y = int(lm.x * img_w), int(lm.y * img_h)
                        face_2d.append([x, y])
                        face_3d.append([x, y, lm.z])  
                face_2d = np.array(face_2d, dtype=np.float64)
                face_3d = np.array(face_3d, dtype=np.float64)

                # The camera matrix
                focal_length = 1 * img_w
                cam_matrix = np.array([ [focal_length, 0, img_h / 2],
                        [0, focal_length, img_w / 2],
                        [0, 0, 1]])
    
                dist_matrix = np.zeros((4, 1), dtype=np.float64)# The Distance Matrix
                success, rot_vec, trans_vec = cv2.solvePnP(face_3d, face_2d, cam_matrix, dist_matrix)# Solve PnP
                rmat, jac = cv2.Rodrigues(rot_vec)# Get rotational matrix
                angles, mtxR, mtxQ, Qx, Qy, Qz = cv2.RQDecomp3x3(rmat)# Get angles
                # Get the y rotation degree
                x = angles[0] * 360
                y = angles[1] * 360
                print(y)
                print(x)
                text=''
                # See where the user's head tilting
                if y < -25:            
                    face = image_input[ytop: ybot, xleft: xright]
                    text = "Looking Left"
                elif y > 25:
                    text = "Looking Right"
                elif x < -25:
                    text = "Up"
                elif x > 25:
                    text = "Down"
                else:
                    text = "Forward"
                    print(text)
                print(text)
                
            else:
                print("no Landmark")
                text="NO landmark"
          except Exception as e: 
            print(e)
          if(text=="Forward"):
          #if(True):
            try:      
                df = DeepFace.find(img_path = face,db_path = database,  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
                match_img=df.iloc[:,0][0]
                rage_veri=df.iloc[:,1][0]
                if(rage_veri>0.19):
                  isExist = os.path.exists(path_unknown)
                  if not isExist:
                    os.makedirs(path_unknown)
                  cv2.imwrite(str(path_unknown)+'/'+str(cam_name)+'_'+str(today)+'_'+str(current_time)+'.jpg', face)
                  continue
            except:
              continue
            print(match_img)
            today = date.today()
            now = datetime.now()
            current_time = now.strftime("%H:%M:%S")
            ctime = now.strftime("%H-%M-%S-%f")
            path_attd = str(detected_img)+"/"+str(today)
                        
            isExist = os.path.exists(path_attd)
            if not isExist:
                os.makedirs(path_attd)                                        
            cv2.imwrite(str(path_attd)+'/'+str(cam_name)+'_'+str(today)+'_'+str(ctime)+'.jpg', face)

            file_path='/var/www/html/ez/python/time.txt'
            if os.path.exists(file_path):
              with open(file_path,'w')as file:
                file.write(str(today)+'_'+str(ctime))
                
            # else:
            #   with open(file_path,'w')as file:
            #     file.write(ctime)

#-------------------TO pass image(Copied from kmc_tec/img_only.py)
            uname1=str(today)+'/'+str(cam_name)+'_'+str(today)+'_'+str(ctime)+'.jpg'
            clientSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            clientSocket.connect((in_ip,int(in_port)))
            clientSocket.send(uname1.encode())
            clientSocket.close()
            name_list.append(uname1) 
#----------------------------------
            #time.sleep(1)          
          continue                           
cv2.destroyAllwindows()
