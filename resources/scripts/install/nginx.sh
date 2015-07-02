#! /bin/bash

# Install it
brew install nginx

# Setup auto start
sudo cp -v /usr/local/opt/nginx/*.plist /Library/LaunchDaemons/
sudo chown root:wheel /Library/LaunchDaemons/homebrew.mxcl.nginx.plist

# Set up the folders
mkdir -p /usr/local/etc/nginx/logs
mkdir -p /usr/local/etc/nginx/sites-available
mkdir -p /usr/local/etc/nginx/sites-enabled
mkdir -p /usr/local/etc/nginx/conf.d
mkdir -p /usr/local/etc/nginx/ssl
sudo mkdir -p /var/www

sudo chown :staff ~/Code
sudo chmod 775 ~/Code

# Get default nginx.conf
rm /usr/local/etc/nginx/nginx.conf
curl -L https://gist.github.com/frdmn/7853158/raw/nginx.conf -o /usr/local/etc/nginx/nginx.conf

# Load php fpm
curl -L https://gist.github.com/frdmn/7853158/raw/php-fpm -o /usr/local/etc/nginx/conf.d/php-fpm

# Create a default virtual host
curl -L https://gist.github.com/frdmn/7853158/raw/sites-available_default -o /usr/local/etc/nginx/sites-available/default

git clone http://git.frd.mn/frdmn/nginx-virtual-host.git ~/Code
rm -rf ~/Code.git

ln -sfv /usr/local/etc/nginx/sites-available/default /usr/local/etc/nginx/sites-enabled/default

# Start it
sudo launchctl load /Library/LaunchDaemons/homebrew.mxcl.nginx.plist

# Make aliases
curl -L https://gist.github.com/frdmn/7853158/raw/bash_aliases -o /tmp/.bash_aliases
cat /tmp/.bash_aliases >> ~/.bash_aliases

if [ -f ~/.bash_profile ]; then
    echo "source ~/.bash_aliases" >> ~/.bash_profile
    . ~/.bash_profile
fi

if [ -f ~/.zshrc ]; then
    echo "source ~/.bash_aliases" >> ~/.zshrc
    . ~/.zshrc
fi