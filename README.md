# Remember Them All
Personal Project: NO.230603

This is a skeleton website which used for words automatic dictation, initially designed for a friend for TEM-4.

You are welcome to contribute.

A words dictation website involves the usage of TTS, PHP and Python3, first written in May 26, 2023, with the assistance of ChatGPT.

Please give all folders (configs, tem4, uploads, word_lists, voices, new_lists) of permission 0777 (execute, read, write).

Main Logic: Use PHP with AJAX to handle form submission, Use python3 to parse raw list files and write the results to "configs/" and "word_lists/" folders, Use Google free Text-to-Speech to convert each word into several mp3 files, and store in "voices/"

# Main Files

index.php -- Program Main Logic and UI

upload_config.sh and upload_lessons.sh -- Uploading all config files and words files to the server

fast_track.py -- Directly converts a specified word to mp3 via TTS

folder_monitor.py -- A guard process converts each word in a word_list file to mp3, upon each word_list comes in "new_lists/" folder

store_config.php -- Generate new configuration file

lrc.py -- Main Parser for the TEM-4 words list

upload.php -- Has the ability to upload a file to the server, stored in "uploads/" folder

execute_python.php -- A bridge connects between PHP and Python3, it enables the execution of Python3 code by calling the shell script by PHP

upload_words -- Able to handle uploads of TXT configuration files
