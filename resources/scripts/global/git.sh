#! /bin/bash

mkdir -p ~/bin
mv resources/scripts/global/git-cam ~/bin/git-cam
mv resources/scripts/global/git-rename ~/bin/git-rename

if [ -f ~/.bash_profile ]; then
    echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bash_profile
    . ~/.bash_profile
fi

if [ -f ~/.zshrc ]; then
    echo 'export PATH="$HOME/bin:$PATH"' >> ~/.zshrc
    . ~/.zshrc
fi

git config --global alias.st "status"
git config --global alias.co "checkout"
git config --global alias.ci "commit"
git config --global alias.br "branch"