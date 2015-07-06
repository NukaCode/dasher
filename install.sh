#! /bin/bash

# Colors
Color_Off='\033[0m'
Yellow='\033[0;33m'
Green='\033[1;32m'
Cyan='\033[0;36m'

read -p "Would you like to install for OSX [1] or Ubuntu [2]?"  OS

if [[ $OS == 2 ]]
then
    . install_ubuntu.sh
else
    . install_osx.sh
fi