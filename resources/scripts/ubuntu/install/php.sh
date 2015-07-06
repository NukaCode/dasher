#! /bin/bash

# Add the repo to apt and update to 5.6
sudo add-apt-repository ppa:ondrej/php5-5.6
sudo apt-get update
sudo apt-get install python-software-properties
sudo apt-get update
sudo apt-get install php5

sudo apt-get install php5-fpm