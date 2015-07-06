# OSX

## Pre-Install
Run `git`.  This will prompt you to set up xcode.  Do this before you run `<path to local dashboard>/install.sh`

## Extra settings needed for Dash to run

### Nginx (local)
```
$NGINX_LOCATION=which nginx
sudo visudo
$USER  ALL=(ALL) NOPASSWD: $NGINX_LOCATION
```

### Homestead
`sudo chmod +a "$USER allow read,write,execute,append" /etc/hosts`

# Ubuntu

## Pre-Install

Service | How to get it
---- | ----
git | sudo apt-get install git

# To-Do

- Move site adding to the job system
    - Possibly only for homestead
- Move site generation to the job system
- Installer
    - Should ask for homestead or nginx/php/mysql
    - Should add a basic group (Default)
    - Should point to the directory local-dash was installed to
    - Should add localdashboard to the default group