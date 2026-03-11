from deepface import DeepFace
from retinaface import RetinaFace
import matplotlib.pyplot as plt
#from picamera2 import Picamera2
import urllib.request
import cv2
#import pyttsx3
#import serial
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
# import keyboard
from deepface.detectors import FaceDetector
import threading
import socket
from jproperties import Properties
import mediapipe as mp
from mediapipe.python.solutions.drawing_utils import _normalized_to_pixel_coordinates

#sudo chmod a+rw /dev/ttyUSB0 ---- permission for port number
#engine = pyttsx3.init()

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
log_data=configs.get("log_data").data
log_unimg=configs.get("log_unimg").data
cam_name=configs.get("cam1_name").data
startimgpath=configs.get("startimgpath").data
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
img_name_count=0
start_face=os.listdir(startimgpath)[0]
print(start_face)
try:
   df = DeepFace.find(img_path = start_face,db_path = "./database_bw",  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
   print("----------------------------------------------")
except Exception as e:
   print("Existssssssssssssssssssssssssssssssssss")
   
logoimage = cv2.imread(main_display_img)
cv2_im_rgb = cv2.cvtColor(logoimage,cv2.COLOR_BGR2RGB)
pil_im = Image.fromarray(cv2_im_rgb) 
draw = ImageDraw.Draw(pil_im) 
font = ImageFont.load_default()
font_cam = ImageFont.load_default() 
draw.text((450, 53), ' ', font=font,fill="#000")
name_list=[]
pre_list=[]
dis_counter=0
cv2.namedWindow("OUTface", cv2.WND_PROP_FULLSCREEN)
cv2.setWindowProperty("OUTface",cv2.WND_PROP_FULLSCREEN,cv2.WINDOW_FULLSCREEN)
wid=1530
hig=950
cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)
imS = cv2.resize(cv2_im_processed, (wid, hig))
img3 = imS
cv2.imshow('OUTface', imS)
cv2.waitKey(1)
h,w,c=logoimage.shape


def print_name(name_list,y_ax,imS):
    x_offset=400
    y_offset=300
    cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_BGR2RGB)
    imS = cv2.resize(cv2_im_processed, (wid, hig))
    cv2.imshow('OUTface', imS)
    cv2.waitKey(1)
    for names in name_list:
        
        '''x_ax=((w-len(names)*27)/2)-40
        draw.text((x_ax, y_ax), names, font=font_cam,fill="#000")
        y_ax=y_ax+80'''

        print("cv2 processed")
        cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_BGR2RGB)
        imS = cv2.resize(cv2_im_processed, (wid, hig))
        print("Names dddddddddddddddddddddddd",names)
        try:
            '''req = urllib.request.urlopen('http://localhost/ez/admin/detected_img/'+names)
            arr = np.asarray(bytearray(req.read()), dtype=np.uint8) 
            img2 = cv2.imdecode(arr, -1)'''
            img2 = cv2.imread(names)
            img2 = cv2.resize(img2, (500, 500))
            x_offset=int(wid/2-img2.shape[1]/2)
            imS[y_offset:y_offset+img2.shape[0], x_offset:x_offset+img2.shape[1]] = img2
            #img3[100:100,100:100,:] = img2
            cv2.imshow('OUTface', imS)
            cv2.waitKey(1)
            
        except Exception as e:
            print("Gone")
            print(e)
            

    else:
        
        cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_BGR2RGB)


      
def cam_err():
    draw.rectangle(((19, 145), (1376, 732)), fill="red")
    draw.text((400, 220), 'Please contact Administrator', font=font_2,fill="#000")
    cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)
    imS = cv2.resize(cv2_im_processed, (wid, hig))
    cv2.imshow('OUTface', imS)
    cv2.waitKey(1)
    
    
def mouse_click(event, x, y,flags, param):
    if event == cv2.EVENT_RBUTTONDOWN:
        print("mouse right")
        exit()
cv2.setMouseCallback('OUTface', mouse_click)



        
#Display Clock in right top
def clock():
    while(True):
        n = datetime.now()
        date_s = n.strftime("%d/%m/%Y")
        time_s = n.strftime("%I:%M:%S %p")
        font = ImageFont.truetype(font_fr, 60)
        font = ImageFont.truetype(font_fr, 35)
        draw.rectangle(((950, 30), (1250, 115)), fill="white")
        draw.text((1010, 32), str(date_s), font=font,fill="#000")
        draw.text((1000, 78), str(time_s), font=font,fill="#000")
        time.sleep(0.1)

            
class network:
    
  def __init__(self):

    t = threading.Thread(target=self._reader)
    self.name_list=[]
    t.daemon = True
    t.start()

  def _reader(self):
    while(True):

        (clientConnected, clientAddress) = serverSocket.accept();
        dataFromClient = clientConnected.recv(1024)
        na=dataFromClient.decode()
        print("***********")
        print(na)
        nas=na
        if nas=='cam_error':
            cam_err()
            #break
            print("")

    
        if nas=='delete1':
            try:
                del self.name_list[0]
            except:
                print('+++++++++++++++++++delete+++++++++++++++++++=')
        else:
           
                
            if 'OB451' in nas:
                self.name_list=[]
                split_code = nas.split("|")
                code=split_code[0]
                message=split_code[1] +"|obimg"
                nas='obimg'
                self.name_list.append(nas)
                nas=message
     
            if 'OB450' in nas:
                self.name_list=[]
                nas='Waiting for Onboarding'    
                     
            if 'CAM404' in nas:
                self.name_list=[]
                cam_err()
                break

            self.name_list.append(nas)
            dis_y=380
            display_count=0
            #length=len(self.name_list)
            #if length>=2:
             #   del self.name_list[0]
            
    
  def read(self):
      name=self.name_list
      return name
      
  def clear(self):
      self.name_list.clear()
      

class VideoCapture:

  def __init__(self, name):
    if name=='0':
        self.cap = cv2.VideoCapture(0)
    else:
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
    #n=0
    while True:
      ret, frame = self.cap.read()
      #if n<2:
        #n=n+1
        #continue
      #n=0
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
t = threading.Thread(target=clock)
t.daemon = True
t.start()
c=0
new_image='';
fcount=0
i=1
yax=120
dount=0
#name_list=[]
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

numcheck = 1
prevName=''
prev_id=0
print("serial reset")
img_name_count=0
while(True): 
    if(img_name_count>5):
        print('NO Face Detected')
        img_name_count=0 
        #time.sleep(3)
        #ser.write(b'$0')
        #time.sleep(1)
        """draw.rectangle(((19, 145), (1376, 732)), fill="white")
        cv2.imshow('OUTface', imS)
        cv2.waitKey(1)
        img_name_count=0   """
    img_name_count=img_name_count+1

    print_name([],0,imS)

    dis_count=dis_count+1
    time_now = datetime.now()
    date_time = time_now.strftime("%d/%m/%Y, %I:%M:%S %p")
    current_time = time_now.strftime("%H:%M:%S")
    f = open("/opt/lampp/htdocs/ez/python/img_only.txt", "w")
    f.write(str(current_time))
    f.close()
    today = date.today()
    path_unknown = str(log_unimg)+"/"+str(today)
    
    if err_msg==1:
        print('err inside'+str(err_msg))
        continue
    frame = video_cap.read()

    '''cv2.imshow("Camera", frame)
    if cv2.waitKey(1)==ord('q'):
        break'''
        


    
    image_rows, image_cols, _ = frame.shape
    image_input = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    results = mp_face.process(image_input)
    if not results.detections: 
    	continue
    
    if(1 == 2):
        print("Nothing in the frame")
        continue
    else:
    
        face_3d = []
        face_2d = []
        text = ""
        img = frame
        pre_face=frame
        for detection in results.detections:
          # print("@@@@@@@@@@@@@@@@@@@")
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
                if y < -5:            
                    face = image_input[ytop: ybot, xleft: xright]
                    text = "Looking Left"
                elif y > 5:
                    text = "Looking Right"
                elif x < -15:
                    text = "Up"
                elif x > 15:
                    text = "Down"
                else:
                    text = "Forward"
                    # print(text)
                print(text)
                #text = "Forward"
                
            else:
                print("no Landmark")
                #text="NO landmark"
          except Exception as e:
            print(e)
          isExist = os.path.exists(path_unknown)
          if not isExist:
              os.makedirs(path_unknown)
          #cv2.imwrite(str(path_unknown)+'/'+str(cam_name)+'_'+str(today)+'_'+str(current_time)+'.jpg', face)
          # os.replace(f'/opt/lampp/htdocs/ez/admin/detected_img/{today}/{face}', f'/opt/lampp/htdocs/ez/python/log_unknownimg/{today}/{face}')
          if(text=="Forward"):
            try: 
                   
                df = DeepFace.find(img_path = face,db_path = database,  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
                match_img=df.iloc[:,0][0]
                
                img_name_split1=match_img.split('/')
                img_name1=img_name_split1[2]
                img_name_split2=img_name1.split('_')
                img_name_id=img_name_split2[0]
                img_name=img_name_split2[1] 
                prev_id=img_name_id
                rage_veri=df.iloc[:,1][0]
                print("#####################")
                
                print(rage_veri)
                if(rage_veri>0.19):
                  
                  print(rage_veri)
                  print("---Greater Range than 0.19---") 
                  isExist = os.path.exists(path_unknown)
                  if not isExist:
                    os.makedirs(path_unknown)
                  cv2.imwrite(str(path_unknown)+'/'+str(cam_name)+'_'+str(today)+'_'+str(current_time)+'.jpg', face)
                  os.replace(f'/opt/lampp/htdocs/ez/admin/detected_img/{today}/{face}', f'/opt/lampp/htdocs/ez/python/log_unknownimg/{today}/{face}')
                  continue
                
                else:
                #-----------led message start-----------------
                    detected_name=r"{matchimg}".format(matchimg=img_name)
                    encoded_message=detected_name.encode('utf-8')
                
                    try:
                    #write message to led
                        print("Image Matched")
                        print(match_img)
                        #ser.write(b' ') 
                        #ser.write(encoded_message)
                        #time.sleep(3)
                        img_name_count=0
                    except Exception as e: 
                        print("Inside Serial assign exception")
                        #ser.close()
                        #ser = serial.Serial('/dev/ttyUSB0', 9600)                
            except Exception as e:
              print("Inside Exception :",e)
              continue
            today = date.today()
            now = datetime.now()
            current_time = now.strftime("%H:%M:%S")
            ctime = now.strftime("%H-%M-%S-%f")
            path_attd = str(detected_img)+"/"+str(today)
                        
            isExist = os.path.exists(path_attd)
            if not isExist:
                os.makedirs(path_attd)                                        
            cv2.imwrite(str(path_attd)+'/'+str(cam_name)+'_'+str(today)+'_'+str(ctime)+'.jpg', face)

            file_path='/opt/lampp/htdocs/ez/python/time.txt'
            if os.path.exists(file_path):
              with open(file_path,'w')as file:
                file.write(str(today)+'_'+str(ctime))    
          #print("Img count :",img_name_count)
          
#-------------------TO pass )
            uname1=str(path_attd)+'/'+str(cam_name)+'_'+str(today)+'_'+str(ctime)+'.jpg'
            '''clientSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            clientSocket.connect((in_ip,int(in_port)))
            clientSocket.send(uname1.encode())
            clientSocket.close()'''
            name_list.append(uname1) 
            print(uname1)
            na=name_list
            name_len=len(na)
            if na==pre_list and name_len>0:
                dis_counter=dis_counter+1
            #if dis_counter>=5:
                #del na[0]
            if name_len<3:
                dis_y=380
            elif name_len==3:
                dis_y=300
            else:
                dis_y=220
            pre_list=na
            print(na)
    
            print_name(na,dis_y,imS)
            na.clear()
            time.sleep(1)
           
    #time.sleep(0.1)
#----------------------------------
             
#ser.close()
cv2.destroyAllwindows()
