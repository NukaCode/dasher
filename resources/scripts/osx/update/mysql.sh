#! /bin/bash

# Create the database, the user and set up the .env file
sudo launchctl load -w /System/Library/LaunchDaemons/com.apple.locate.plist

MYSQL=`which mysql`

read -p "What is the name of the database you would like to use for the dashboard?  " DB_NAME
read -p "What is the name of the user that can access the database?                 " DB_USER
read -p "What is the password for this user?                                        " DB_PASS

Q1="CREATE DATABASE IF NOT EXISTS $DB_NAME;"
Q2="GRANT USAGE ON *.* TO $DB_USER@localhost IDENTIFIED BY '$DB_PASS';"
Q3="GRANT ALL PRIVILEGES ON $DB_NAME.* TO $DB_USER@localhost;"
Q4="FLUSH PRIVILEGES;"
SQL="${Q1}${Q2}${Q3}${Q4}"

echo -e "${Yellow}Mysql is going to ask you for the root password.  By default, it is blank."
$MYSQL -uroot -p -e "$SQL"

cp .env.example .env
sed -i.bak s/{{DB_NAME}}/"$DB_NAME"/g .env
sed -i.bak s/{{DB_USER}}/"$DB_USER"/g .env
sed -i.bak s/{{DB_PASS}}/"$DB_PASS"/g .env

rm -f .env.bak