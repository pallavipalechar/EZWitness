import time
import subprocess
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

class FileDeletionHandler(FileSystemEventHandler):
  def __init__(self):
    super().__init__()

  def on_deleted(self, event):
    if not event.is_directory and event.src_path.endswith('pickle_Exists.txt'):

     Generate_Pickle()

def Generate_Pickle():
  print("On process")
  subprocess.run(["sh", "/opt/lampp/htdocs/ez/python/generate_pickle.sh"])

def main():
  path_to_watch = '/opt/lampp/htdocs/ez/python/pickle'
  onboard_deletion_handler = FileDeletionHandler()
  observer = Observer()
  observer.schedule(onboard_deletion_handler, path=path_to_watch, recursive=False)
  observer.start()

  try:
    while True:
      time.sleep(1)
  except KeyboardInterrupt:
    observer.stop()
  observer.join()

if __name__ == "__main__":
  main()

