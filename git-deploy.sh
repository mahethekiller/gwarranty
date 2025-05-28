#!/bin/bash

# Set working directory and log file
WORK_DIR="/home/greenlamwarranty/public_html"
LOG_FILE="/home/greenlamwarranty/public_html/deploy-log.txt"

# Timestamp
echo "----------------------------" >> $LOG_FILE
echo "Deploy attempt: $(date)" >> $LOG_FILE

# Change to project directory
cd $WORK_DIR

# Pull latest changes and capture output
GIT_OUTPUT=$(git pull origin main 2>&1)

# Log git output
echo "$GIT_OUTPUT" >> $LOG_FILE

# Final log line
if [[ $GIT_OUTPUT == *"Already up to date."* || $GIT_OUTPUT == *"files changed"* ]]; then
    echo "✅ Deployment successful." >> $LOG_FILE
else
    echo "⚠️ Deployment may have failed or no changes were found." >> $LOG_FILE
fi

echo "" >> $LOG_FILE


