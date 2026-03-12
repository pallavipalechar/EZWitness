#!/bin/bash

# Step 1: Clone the repository
git clone -b master https://github.com/pallavipalechar/EZWitness.git

# Step 2: Navigate to the directory with the zip files
cd /opt/lampp/htdocs/ez/python/brevera_backup/cam2/ || exit

# Step 3: Find the latest zip file starting with 'database_bw_'
latest_zip=$(find . -name 'database_bw_*.zip' -printf '%T+ %p\n' | sort -r | head -n 1 | awk '{print $2}')

echo "The latest zip file is: $latest_zip"

# Step 4: Unzip the latest zip file
unzip -o "$latest_zip" -d /opt/lampp/htdocs/ez/python/

# Step 5: Set full read and write permissions
chmod -R 777 /opt/lampp/htdocs/ez/python/database_bw/

# Step 6: Remove cloned repository
rm -rf /opt/lampp/htdocs/ez/python/brevera_backup