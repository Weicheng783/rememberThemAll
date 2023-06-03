import os
import time
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
from gtts import gTTS
import sys
import re

def remove_whitespace_lines(text):
    # Split the text into lines
    lines = text.split('\n')

    # Create a regular expression pattern to match lines with only whitespace and alphabetic characters
    pattern = r'^[a-zA-Z\s]*$'

    # Filter out lines that match the pattern
    filtered_lines = [line for line in lines if not re.match(pattern, line)]

    # Join the filtered lines back into a string
    filtered_text = '\n'.join(filtered_lines)

    return filtered_text

argument = sys.argv[1]

ss = "./voices/"
mp3_filename = argument + '.mp3'
mp3_path = os.path.join(ss, mp3_filename)

argument = remove_whitespace_lines(text)

if os.path.exists(mp3_path):
    print(f"Removing {mp3_filename} - already exists")
    os.remove(mp3_path)
print(f"Converting text '{argument}' to speech...")
tts = gTTS(argument)
try:
    tts.save(mp3_path)
except:
    pass
print(f"Saved {mp3_filename} in './voices/'")


