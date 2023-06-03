#!/bin/bash

for lesson in {1..36}; do
    source_file="configs/Lesson $lesson.json"
    destination_file="ubuntu@132.145.27.119:/var/www/html/voices/configs/Lesson $lesson.json"
    
    scp -i /Users/weicheng/Linux/ssh-key-2022-12-21.key.pub "$source_file" "$destination_file"
    
    sleep 0.3
done
