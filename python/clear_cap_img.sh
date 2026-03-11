#!/bin/bash
#To clear cap_image after 15 days
CAP_IMG="/opt/lampp/htdocs/ez/admin/cap_img"
find $CAP_IMG -mindepth 1 -mmin +3 -exec rm -rf {} \;
