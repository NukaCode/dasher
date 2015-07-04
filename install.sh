#! /bin/bash

# Colors
Color_Off='\033[0m'
Yellow='\033[0;33m'
Green='\033[1;32m'
Cyan='\033[0;36m'

echo 'Starting the installer...'

####################################################################################################################
############ Xcode
####################################################################################################################
#echo -e "${Green}Installing xcode (click install)...'
#. resources/scripts/install/xcode.sh

#echo 'Open Xcode, hit ⌘ + , to access the Preferences and navigate to the Locations tab. Set the Command Line Tools to the latest version available...'
#read -p "Press [Enter] when done ..."

####################################################################################################################
############ Homebrew
####################################################################################################################
variable=`brew -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing homebrew... $Color_Off"
    . resources/scripts/install/homebrew.sh
else
    echo -e "${Cyan}Homebrew already installed... $Color_Off"
fi

read -p "Update homebrew [Y/N]?  " upbrew
case upbrew in
    [yY][eE][sS]|[yY])
        echo -e "${Green}Updating homebrew... $Color_Off"
        . resources/scripts/update/homebrew.sh
        ;;
esac

####################################################################################################################
############ Composer
####################################################################################################################
variable=`composer --version`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing composer... $Color_Off"
    . resources/scripts/install/composer.sh
else
    echo -e "${Cyan}Composer already installed... $Color_Off"
fi

####################################################################################################################
############ MySQL
####################################################################################################################
variable=`mysql --version`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing mysql... $Color_Off"
    . resources/scripts/install/mysql.sh
else
    echo -e "${Cyan}Mysql already installed... $Color_Off"
fi

####################################################################################################################
############ PHP
####################################################################################################################
variable=`php -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing PHP... $Color_Off"
    . resources/scripts/install/php.sh
else
    echo -e "${Cyan}PHP already installed... $Color_Off"
fi

####################################################################################################################
############ Nginx
####################################################################################################################
variable=`nginx -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing Nginx... $Color_Off"
    . resources/scripts/install/nginx.sh
else
    echo -e "${Cyan}Nginx already installed... $Color_Off"
fi

####################################################################################################################
############ Node
####################################################################################################################
variable=`node -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing Node... $Color_Off"
    . resources/scripts/install/node.sh
else
    echo -e "${Cyan}Node already installed... $Color_Off"
fi

read -p "Update npm [Y/N]?  " upbrew
case upbrew in
    [yY][eE][sS]|[yY])
        echo -e "${Green}Updating NPM... $Color_Off"
        sudo npm install npm -g
        ;;
esac

####################################################################################################################
############ Bower
####################################################################################################################
variable=`bower -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing Bower... $Color_Off"
    . resources/scripts/install/bower.sh
else
    echo -e "${Cyan}Bower already installed... $Color_Off"
fi

####################################################################################################################
############ Gulp
####################################################################################################################
variable=`gulp -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing Gulp... $Color_Off"
    . resources/scripts/install/gulp.sh
else
    echo -e "${Cyan}Gulp already installed... $Color_Off"
fi

####################################################################################################################
############ Finishing the Site
####################################################################################################################
echo -e "${Yellow}Setting up the site... $Color_Off"
#php artisan key:generate
#sudo npm install
#bower install

echo 'Finished with initial install!'