#!/bin/bash
#To clear unknown_image after 2 days
UNKNOWN_IMG="/opt/lampp/htdocs/ez/python/log_unknownimg"
find $UNKNOWN_IMG -mindepth 1 -mtime +2 -exec rm -rf {} \;
