

#!/bin/bash

# Set your database credentials and other parameters
DB_USER="root"
DB_PASSWORD="1234"
DB_NAME="ez_db"
BACKUP_DIR="/opt/lampp/htdocs/ez/python/cam1"
DAYS_TO_KEEP=1
DATABASE_BW_DIR="/opt/lampp/htdocs/ez/python/database_bw"

# Create a timestamp for the backup file
TIMESTAMP=$(date +"%Y-%m-%d@%H:%M")

# Dump the database to a SQL file
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/ez_db_$TIMESTAMP.sql

# Compress the backup SQL file
gzip $BACKUP_DIR/ez_db_$TIMESTAMP.sql

# Change to the directory containing the 'database_bw' folder
cd /opt/lampp/htdocs/ez/python

# Zip the 'database_bw' folder without including the full path
zip -r $BACKUP_DIR/database_bw_$TIMESTAMP.zip database_bw

# Remove backups older than the specified number of days
find $BACKUP_DIR -name "ez_db_*" -type f -mtime +$DAYS_TO_KEEP -exec rm {} \;
find $BACKUP_DIR -name "database_bw_*" -type f -mtime +$DAYS_TO_KEEP -exec rm {} \;
