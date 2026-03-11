#!/bin/bash

# Set Git configuration to store credentials
git config credential.helper store

# Change directory to the root of your Git repository
cd /var/www/html/ez/python

# Verify and set the 'origin' remote if necessary
git remote -v
git remote add origin https://github.com/ezwitnessmlr/brevera_backup.git

# Fetch the latest changes from the remote repository
echo "Fetching latest changes from remote repository..."
git fetch origin master

# Merge the fetched changes into your local branch
echo "Merging fetched changes into local branch..."
git merge origin/master --allow-unrelated-histories --no-edit

# Remove all files from the cam2 folder in the repository
git rm -r --cached cam1/*

# Add the files in your local cam2 folder to the staging area
git add cam1/*

# Commit the changes
git commit -m "Committing backup files"

# Push the changes to your GitHub repo using stored credentials
git push origin master:master --follow-tags --no-verify

