#! /bin/bash

echo 'Starting the installer...'

####################################################################################################################
############ Xcode
####################################################################################################################
echo -e "${Green}Installing xcode (click install)...'
. resources/scripts/osx/install/xcode.sh

echo 'Open Xcode, hit ⌘ + , to access the Preferences and navigate to the Locations tab. Set the Command Line Tools to the latest version available...'
read -p "Press [Enter] when done ..."

####################################################################################################################
############ Git
####################################################################################################################
echo -e "${Green}Setting up common git aliases...'
. resources/scripts/global/git.sh

####################################################################################################################
############ Homebrew
####################################################################################################################
variable=`brew -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing homebrew... $Color_Off"
    . resources/scripts/osx/install/homebrew.sh
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
    . resources/scripts/osx/install/composer.sh
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
    . resources/scripts/osx/install/mysql.sh
else
    echo -e "${Cyan}Mysql already installed... $Color_Off"
fi

. resources/scripts/update/mysql.sh

####################################################################################################################
############ PHP
####################################################################################################################
echo -e "${Green}Installing PHP... $Color_Off"
. resources/scripts/osx/install/php.sh

####################################################################################################################
############ Nginx
####################################################################################################################
variable=`nginx -v`
rc=$?

if [[ $rc != 0 ]]
then
    echo -e "${Green}Installing Nginx... $Color_Off"
    . resources/scripts/osx/install/nginx.sh
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
    . resources/scripts/osx/install/node.sh
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
    . resources/scripts/osx/install/bower.sh
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
    . resources/scripts/osx/install/gulp.sh
else
    echo -e "${Cyan}Gulp already installed... $Color_Off"
fi

####################################################################################################################
############ Finishing the Site
####################################################################################################################
echo -e "${Yellow}Downloading composer packages... $Color_Off"
composer install
echo -e "${Yellow}Generating a key... $Color_Off"
php artisan key:generate
echo -e "${Yellow}Gathering needed compoenents... $Color_Off"
sudo npm install
bower install
echo -e "${Yellow}Running migrations... $Color_Off"
php artisan migrate --seed

echo 'Finished with initial install!'