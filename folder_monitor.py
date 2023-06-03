import os
import time
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
from gtts import gTTS


def convert_text_to_speech(text, output_path):
    tts = gTTS(text)
    try:
        tts.save(output_path)
    except:
        pass


def process_file(filename):
    if not filename.endswith('.txt'):
        return

    input_file_path = os.path.join('new_lists', filename)
    output_dir = 'voices'
    os.makedirs(output_dir, exist_ok=True)

    with open(input_file_path, 'r') as file:
        lines = file.read().splitlines()

    for line in lines:
        for ss in line.split(","):
            mp3_filename = ss + '.mp3'
            mp3_path = os.path.join(output_dir, mp3_filename)

            if os.path.exists(mp3_path):
                print(f"Skipping {mp3_filename} - already exists")
            else:
                try:
                    print(f"Converting text '{line}' to speech...")
                    convert_text_to_speech(ss, mp3_path)
                    print(f"Saved {mp3_filename} in './voices/'")
                except:
                    pass

    os.remove(input_file_path)
class NewFileEventHandler(FileSystemEventHandler):
    def on_created(self, event):
        if event.is_directory:
            return

        filename = os.path.basename(event.src_path)
        time.sleep(5)
        process_file(filename)


if __name__ == '__main__':
    event_handler = NewFileEventHandler()
    observer = Observer()
    observer.schedule(event_handler, './new_lists/', recursive=False)
    observer.start()

    try:
        pass
    except KeyboardInterrupt:
        observer.stop()

    observer.join()

