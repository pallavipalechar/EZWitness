from flask import Flask,render_template,request
from flask_socketio import SocketIO, emit,join_room, leave_room
from deepface import DeepFace
import cv2
import numpy as np
import glob, os
import time
from datetime import date
from datetime import datetime
from PIL import ImageFont, ImageDraw, Image
import uuid
import threading, queue
from deepface.detectors import FaceDetector
import threading
import sys
from cryptography.fernet import Fernet
from datetime import datetime, timedelta
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
rtsp_url=configs.get("rtsp_url_cam2").data
database=configs.get("database").data
database_bw=configs.get("database_bw").data
detected_img=configs.get("detected_img").data
log_unimg=configs.get("log_unimg").data
cam_name=configs.get("cam1_name").data
startimgpath=configs.get("startimgpath").data
start_face=os.listdir(startimgpath)[0]

try:
   df = DeepFace.find(img_path = start_face,db_path = "./database_bw",  model_name = "Facenet512",distance_metric ="cosine",enforce_detection=False,detector_backend="mediapipe")
   print("----------------------------------------------")
except Exception as e:
   print("Existssssssssssssssssssssssssssssssssss")



app = Flask(__name__)
socketio = SocketIO(app,debug=True,cors_allowed_origins='*',async_mode='eventlet')


@app.route('/index')
def main():
        return render_template('base.html')
    
    
@socketio.on('connect')
def handle_connect():
    device_id = request.args.get('mob2')  # Assuming device_id is passed as a query parameter
    join_room(device_id)

@socketio.on('disconnect')
def handle_disconnect():
    device_id = request.args.get('mob2')
    leave_room(device_id)
        
class network:
    
  def __init__(self):

    t = threading.Thread(target=self._reader)
    self.name_list=[]
    t.daemon = True
    t.start()


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
        os._exit(1)
        
      if not self.q.empty():
        try:
          self.q.get_nowait()   # discard previous (unprocessed) frame
        except queue.Empty:
          pass
      self.q.put(frame)

  def read(self):
    return self.q.get()

video_cap = VideoCapture(rtsp_url)
err_msg=0
prev_id=0
img_name_count=0
dis_count=0
name_list=[]
pre_list=[]

@socketio.on("my_event")
def checkping():
    sid = request.sid
    print(sid)
    while(True):
        global img_name_count
        if(img_name_count>5):
            print('NO Face Detected')
    
        img_name_count=img_name_count+1
        global dis_count
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
                        
                        focal_length = 1 * img_w
                        cam_matrix = np.array([ [focal_length, 0, img_h / 2],[0, focal_length, img_w / 2],[0, 0, 1]])
                        dist_matrix = np.zeros((4, 1), dtype=np.float64)
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
                    else:
                        print("no Landmark")
                except Exception as e:
                    print(e)
                isExist = os.path.exists(path_unknown)
                if not isExist:
                    os.makedirs(path_unknown)
                cv2.imwrite(str(path_unknown)+'/'+str(cam_name)+'_'+str(today)+'_'+str(current_time)+'.jpg', frame)
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
                            emit('server', {"data":img_name, "data1":prev_id}, room=sid)
                            if not isExist:
                                os.makedirs(path_unknown)
                            cv2.imwrite(str(path_unknown)+'/'+str(cam_name)+'_'+str(today)+'_'+str(current_time)+'.jpg', face)
                            # os.replace(f'/opt/lampp/htdocs/ez/admin/detected_img/{today}/{face}', f'/opt/lampp/htdocs/ez/python/log_unknownimg/{today}/{face}')
                            continue
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
                    uname1=str(path_attd)+'/'+str(cam_name)+'_'+str(today)+'_'+str(ctime)+'.jpg'  
                    
                    
        #emit('server', {"data":img_name, "data1":prev_id}, room=sid)                
                                
    
    
    
    
    # for x in range(5):
    #     sid = request.sid
    #     print("11111")
    #     emit('server', {"data1":x, "data":'listing1.stdout'}, room=sid)
        socketio.sleep(3)

if __name__ == '__main__':
    socketio.run(app,port=7000, debug=True,host="0.0.0.0")
