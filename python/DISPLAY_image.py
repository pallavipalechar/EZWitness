import cv2
import time
import numpy as np
from PIL import ImageFont, ImageDraw, Image
from jproperties import Properties
configs = Properties()
import socket
import time
from datetime import date
from datetime import datetime
import datetime as dt
import threading
import urllib.request
import random
import sys
import os
from multiprocessing import Process 
serverSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM);
serverSocket.bind(("",9202));
serverSocket.listen();

multi_win=0
with open('/opt/lampp/htdocs/ez/python/fr_allconfig/EZWitness_config.properties', 'rb') as read_prop:
    configs.load(read_prop)


main_display_img=configs.get("main_display_img").data
font_2fr=configs.get("font_fr").data
font_fr=configs.get("font_fr").data
font_2 = ImageFont.truetype(font_2fr, 60) 
font_cam = ImageFont.truetype(font_2fr, 50) 
kmcimage = cv2.imread(main_display_img)
cv2_im_rgb = cv2.cvtColor(kmcimage,cv2.COLOR_BGR2RGB)
pil_im = Image.fromarray(cv2_im_rgb) 
draw = ImageDraw.Draw(pil_im) 
font = ImageFont.truetype(font_fr, 60)

draw.text((450, 53), '', font=font,fill="#000")
name_list=[]
cv2.namedWindow("OUTface", cv2.WND_PROP_FULLSCREEN)
cv2.setWindowProperty("OUTface",cv2.WND_PROP_FULLSCREEN,cv2.WINDOW_FULLSCREEN)
wid=1550
hig=950
cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)
imS = cv2.resize(cv2_im_processed, (wid, hig))
img3 = imS
cv2.imshow('OUTface', imS)
cv2.waitKey(1)
h,w,c=kmcimage.shape
#-----------Print Name----------------
na=''
i=0

def print_name(name_list,y_ax,imS):
    print("aaaaaaaaaaaaaaaaaaaaaaaaaa")
    print(name_list)
    draw.rectangle(((19, 145), (1376, 732)), fill="white") 
    x_offset=400
    y_offset=300
    cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)
    imS = cv2.resize(cv2_im_processed, (wid, hig))
        
    cv2.imshow('OUTface', imS)
    cv2.waitKey(1)
    for names in name_list:
        """
        x_ax=((w-len(names)*27)/2)-40
        draw.text((x_ax, y_ax), names, font=font_cam,fill="#000")
        y_ax=y_ax+80
        """
        
        cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)
        imS = cv2.resize(cv2_im_processed, (wid, hig))
        print("Names",names)
        try:
            #req = urllib.request.urlopen('http://localhost/ez/admin/detected_img/'+names)
            #arr = np.asarray(bytearray(req.read()), dtype=np.uint8)
            
            #img2 = cv2.imdecode(arr, -1)
            img2 = cv2.imread("/opt/lampp/htdocs/ez/admin/detected_img/" + names)
            img2 = cv2.resize(img2, (500, 500))
            x_offset=int(wid/2-img2.shape[1]/2)
                
            imS[y_offset:y_offset+img2.shape[0], x_offset:x_offset+img2.shape[1]] = img2
            #img3[100:100,100:100,:] = img2
            print("FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF")
            cv2.imshow('OUTface', imS)
            cv2.waitKey(1)
            
        except Exception as e:
            print("Gone")
            

    else:
        
        cv2_im_processed = cv2.cvtColor(np.array(pil_im), cv2.COLOR_RGB2BGR)


      
def cam_err():
    draw.rectangle(((19, 145), (1376, 732)), fill="white")
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
      
#----------Display Name--------------

length=0
network_display=network()
pre_list=[]
dis_counter=0
re_counter=0
x_offset1=100
while(True):
    time_now = datetime.now()
    current_time = time_now.strftime("%H:%M:%S")
    f = open("/opt/lampp/htdocs/ez/python/display.txt", "w")
    f.write(str(current_time))
    f.close()	
    font = ImageFont.truetype(font_fr, 60)
    n = datetime.now()
    date_s = n.strftime("%d/%m/%Y")
    time_s = n.strftime("%I:%M:%S %p")
    font = ImageFont.truetype(font_fr, 35)
    draw.rectangle(((950, 30), (1250, 115)), fill="white")
    draw.text((1010, 32), str(date_s), font=font,fill="#000")
    draw.text((1000, 78), str(time_s), font=font,fill="#000")
    
    na = network_display.read()
    if 'Quit' in na:
        break
    
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
    if na!=[]:        
        if 'Onboard' in na[0]:
        	if 'Successfull' in na[0]:
        		x_offset1=100
        		imS = cv2.resize(cv2_im_processed, (wid, hig))
        	print_onboard(na,dis_y)
        elif 'obimg' in na[0]:
        	#imS = cv2.resize(cv2_im_processed, (wid, hig))
        	print_onboard_img(na,dis_y,imS,x_offset1)
        	x_offset1=x_offset1+220
        else:
        	print("nnnnnnnnnnnnnnnnnnnnnnn")
        	print_name(na,dis_y,imS)
        	network_display.clear()
    else:
        print_name(na,dis_y,imS)
        network_display.clear()
    time.sleep(1)
   
    na=''
    
cv2.destroyAllWindow()

