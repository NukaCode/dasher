#! /bin/bash

composer=`composer`
rc=$?

if [[ $rc != 0 ]]
then
    # Install it
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

    # Snag the nuka installer
    composer global require "nukacode/installer"

    if [ -f ~/.bash_profile ]; then
        echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.bash_profile
        source ~/.bash_profile
    fi

    if [ -f ~/.zshrc ]; then
        echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.zshrc
        . ~/.zshrc
    fi
else
    echo -e "${Cyan}Composer already installed... $Color_Off"
fi