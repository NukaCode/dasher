#! /bin/bash

# Snag the nuka installer
composer global require "laravel/envoy"

if [ -f ~/.bash_profile ]; then
    echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.bash_profile
    source ~/.bash_profile
fi

if [ -f ~/.zshrc ]; then
    echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.zshrc
    . ~/.zshrc
fi