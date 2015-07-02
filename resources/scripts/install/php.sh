#! /bin/bash

# Add the taps to homebrew to get php-fpm
brew tap homebrew/dupes
brew tap homebrew/php

# Install php with the needed bits
brew install --without-apache --with-fpm --with-mysql php56

brew install php56-mcrypt

# Update the path variable
if [ -f ~/.bash_profile ]; then
    echo 'export PATH="/usr/local/sbin:$PATH"' >> ~/.bash_profile
    . ~/.bash_profile
fi

if [ -f ~/.zshrc ]; then
    echo 'export PATH="/usr/local/sbin:$PATH"' >> ~/.zshrc
    . ~/.zshrc
fi

# Setup auto start
mkdir -p ~/Library/LaunchAgents
ln -sfv /usr/local/opt/php56/homebrew.mxcl.php56.plist ~/Library/LaunchAgents/

# Start it
launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.php56.plist
