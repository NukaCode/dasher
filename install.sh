#! /bin/bash

echo 'Starting the installer...'

echo 'Installing xcode (click install)...'
./resources/scripts/install/xcode.sh

echo 'Open Xcode, hit ⌘ + , to access the Preferences and navigate to the Locations tab. Set the Command Line Tools to the latest version available...'
read -p "Press [Enter] ..."

echo 'Installing homebrew...'
./resources/scripts/install/homebrew.sh

echo 'Installing composer...'
./resources/scripts/install/composer.sh

echo 'Installing mysql...'
./resources/scripts/install/mysql.sh

echo 'Installing php...'
./resources/scripts/install/php.sh

echo 'Installing nginx...'
./resources/scripts/install/nginx.sh

echo 'Finished with initial install!'