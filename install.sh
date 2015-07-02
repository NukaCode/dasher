#! /bin/bash

echo 'Starting the installer...'

echo 'Installing xcode command line tools (set "Command Line Tools" to the latest version)...'
./resources/scripts/install/xcode.sh

echo 'Installing homebrew...'
./resources/scripts/install/homebrew.sh

echo 'Installing git...'
./resources/scripts/install/git.sh

echo 'Installing composer...'
./resources/scripts/install/composer.sh

echo 'Installing mysql...'
./resources/scripts/install/mysql.sh

echo 'Installing php...'
./resources/scripts/install/php.sh

echo 'Installing nginx...'
./resources/scripts/install/nginx.sh

echo 'Finished with initial install!'