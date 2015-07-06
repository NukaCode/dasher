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