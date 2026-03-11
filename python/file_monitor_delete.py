import time
import subprocess
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

class FileDeletionHandler(FileSystemEventHandler):
  def __init__(self):
    super().__init__()

  def on_deleted(self, event):
    if not event.is_directory and event.src_path.endswith('start_onboard.txt'):
     print(f"File '{event.src_path}' was deleted. Stopping onboard.py...")
     stop_onboard_script()

def stop_onboard_script():
  print("inside stop")
  subprocess.run(["sh", "/opt/lampp/htdocs/ez/python/stop_process.sh"])

def main():
  path_to_watch = '/opt/lampp/htdocs/ez/python/watchdog'
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
