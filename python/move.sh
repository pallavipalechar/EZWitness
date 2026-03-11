#!/bin/bash
source_dir="/home/manipal/campic121/Output/2024-05-01"
target_dir="/home/manipal/campic121/7J02EE3PAG7C51C/2024-05-02"
extension="txt"  # Replace with your desired file extension

while true; do
    files_to_move=$(find "$source_dir" -maxdepth 1 -type f -name "*.$extension" | head -n 5)
    if [ -z "$files_to_move" ]; then
        break  # No more files to move
    fi

    for file in $files_to_move; do
        mv -v "$file" "$target_dir"
    done

    sleep 20  # Introduce a 20-second delay
done

# Move files from source directory to destination directory with a 20-second delay
sleep 20 && mv /home/manipal/campic121/Output/2024-05-01*.jpg /home/manipal/campic121/7J02EE3PAG7C51C/2024-05-02/