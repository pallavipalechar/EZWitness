import time
import subprocess
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

class FileCreationHandler(FileSystemEventHandler):
  def __init__(self):
    super().__init__()

  def on_created(self, event):
    if not event.is_directory and event.src_path.endswith('start_onboard.txt'):
     print(f"File '{event.src_path}' was created. Starting onboard.py...")
     start_onboard_script()

def start_onboard_script():
  subprocess.run(["sh", "/opt/lampp/htdocs/ez/python/start_process.sh"])


def main():
  path_to_watch = '/opt/lampp/htdocs/ez/python/watchdog'
  event_handler = FileCreationHandler()
  observer = Observer()
  observer.schedule(event_handler, path=path_to_watch, recursive=False)
  observer.start()

  try:
    while True:
      time.sleep(1)
  except KeyboardInterrupt:
    observer.stop()
  observer.join()

if __name__ == "__main__":
  main()
