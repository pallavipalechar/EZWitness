import requests
import datetime
r2= requests.post('http://localhost/ez/admin/gen_att.php', data={'data':'no data'})
print(r2.text)
#current_time = datetime.datetime.now()
#f = open("/opt/lampp/htdocs/ez/python/atted_up_time.txt", "a")
#f.write('\n'+str(current_time)+str(r2.text))
#f.close()	
