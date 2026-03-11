from deepface import DeepFace
from retinaface import RetinaFace
import matplotlib.pyplot as plt
import cv2
import numpy as np
import glob, os
import time
import shutil
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
with open('/opt/lampp/htdocs/ez/python/fr_allconfig/EZWitness_config.properties', 'rb') as read_prop:
    configs.load(read_prop)
rtsp_url=configs.get("rtsp_url_cam1").data
database=configs.get("database").data
database_bw=configs.get("database_bw").data
localsite=configs.get("localsite").data
detected_img=configs.get("detected_img").data
startimgpath=configs.get("startimgpath").data
start_face=os.listdir(startimgpath)[0]
#start_face=configs.get("start_face").data
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
time_now = datetime.now()
date_time = time_now.strftime("%d/%m/%Y, %I:%M:%S %p")
current_time = time_now.strftime("%H:%M:%S")
f = open("/opt/lampp/htdocs/ez/python/img_only.txt", "w")
f.write(str(current_time))
f.close()
try:
   df = DeepFace.find(img_path = start_face,db_path = "./database_bw",  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
   print("----------------------------------------------")
except Exception as e:
   print("Existssssssssssssssssssssssssssssssssss")
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
today = date.today()
num_images_processed = 0


specific_date = date.today()
#today = date.today()
#specific_date = date.today()
#home_directory =  f"/home/manipal/campic121/7J02EE3PAG7C51C/{specific_date}"

today_date = datetime.now().strftime('%Y-%m-%d')
print(specific_date)

destination_directory = f'/home/manipal/campic121/Output/{specific_date}'
is_exist = os.path.exists(destination_directory)

if not is_exist:
    os.makedirs(destination_directory)
    
           
while True:
    #time.sleep(15)
    #all_images_processed = False
    #home_directory = f'/home/manipal/campic121/Output/{specific_date}'
    home_directory =  f"/home/manipal/campic121/7J02EE3PAG7C51C/{specific_date}"
    for root, dirs, files in os.walk(home_directory):
        for file in files:
            if file.endswith('.jpg'):
                #num_images_processed += 1
                #time.sleep(2)
                image_path = os.path.join(root, file)
                print(image_path)

                frame = cv2.imread(image_path)

                if frame is None:
                    print(f"Failed to read image: {image_path}")
                    continue

                print(f"Processing image: {image_path}")

                image_rows, image_cols, _ = frame.shape
                image_input = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
                results = mp_face.process(image_input)

                if not results.detections:
                    print("No detections found for", os.path.basename(image_path))
                else:
                    print("Detections found for", os.path.basename(image_path))
                    face_3d = []
                    face_2d = []
                    text = ""
                    img = frame
                    pre_face = frame
                    for detection in results.detections:
                        print("Processing detection...")
                        eye_left=mp_face_detection.get_key_point(detection, mp_face_detection.FaceKeyPoint.LEFT_EYE)
                        # print("Left",eye_left)
                        eye_right=mp_face_detection.get_key_point(detection, mp_face_detection.FaceKeyPoint.RIGHT_EYE)
                        # print("Right",eye_right)
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
                                # print(y)
                                # print(x)
                                text=''
                                # See where the user's head tilting
                                if y < -15:            
                                    face = image_input[ytop: ybot, xleft: xright]
                                    text = "Looking Left"
                                elif y > 15:
                                    text = "Looking Right"
                                elif x < -10:
                                    text = "Up"
                                elif x > 10:
                                    text = "Down"
                                else:
                                    text = "Forward"
                                    # print(text)
                                print(text)
                                # text = "Forward"
                                
                            else:
                                print("no Landmark")
                                #text="NO landmark"
                        except Exception as e:
                            print(e)
                        
                        today = date.today()
                        now = datetime.now()
                        current_time = now.strftime("%H:%M:%S")
                        ctime = now.strftime("%H-%M-%S-%f")
                        path_unknown = str(log_unimg)+"/"+str(specific_date)
                        path_attd = str(detected_img)+"/"+str(specific_date)
                        
                        isExist = os.path.exists(path_unknown)
                        if not isExist:
                            os.makedirs(path_unknown)
                        cv2.imwrite(f"{path_unknown}/face_detected_{specific_date}_{ctime}.jpg", face)
                        
                        if(text=="Forward"):
                            try: 
                                df = DeepFace.find(img_path = face,db_path = database,  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
                                match_img=df.iloc[:,0][0]
                                img_name_split1=match_img.split('/')
                                img_name1=img_name_split1[2]
                                img_name_split2=img_name1.split('_')
                                img_name_id=img_name_split2[0]
                                img_name=img_name_split2[1] 
                                #if(prev_id==img_name_id):
                                #    continue
                                prev_id=img_name_id
                                rage_veri=df.iloc[:,1][0]
                                print(rage_veri)
                                if(rage_veri>0.19):
                                
                                    print(rage_veri)
                                    print("---Greater Range than 0.19---") 

                                    isExist = os.path.exists(path_unknown)
                                    if not isExist:
                                        os.makedirs(path_unknown)                                        
                                    cv2.imwrite(f"{path_unknown}/{cam_name}_{specific_date}_{ctime}.jpg", face)
                                    #os.replace(f'/opt/lampp/htdocs/ezwitness/admin/detected_img/{today}/{face}', f'/opt/lampp/htdocs/ezwitness/python/log_unknownimg/{today}/{face}')
                                    continue
                                    
                            except Exception as e:
                                print("Inside Exception :",e)
                                continue
                            isExist = os.path.exists(path_attd)
                            if not isExist:
                                os.makedirs(path_attd)                                        
                            cv2.imwrite(f"{path_attd}/{cam_name}_{specific_date}_{ctime}.jpg", face)
                            
                #os.remove(image_path)
                destination_path = os.path.join(destination_directory, file)
                if os.path.exists(destination_path):
                    os.remove(destination_path)
                shutil.move(image_path, destination_path)
                print(f"Moved {file} to {destination_directory}")

    #all_images_processed = True

    #if all_images_processed:
        #break  
cv2.waitKey(1000)                            
cv2.destroyAllWindows()