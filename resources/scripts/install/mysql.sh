#! /bin/bash

# Install it
brew install mysql

# Setup auto start
ln -sfv /usr/local/opt/mysql/*.plist ~/Library/LaunchAgents

# Start it
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist