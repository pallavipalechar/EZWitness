import os
import time

pickleFilePath = '/opt/lampp/htdocs/ez/python/database_bw/representations_facenet512.pkl'

while not os.path.exists(pickleFilePath):
    time.sleep(2)  # Wait for 2 seconds before checking again

print('true')
