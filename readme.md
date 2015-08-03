# OSX

## Pre-Install
You will need to have everything to run a site.  This includes nginx, mysql, php, git, etc.  You can use [NukaCode\Setup](https://github.com/nukacode/setup) to handle this for you.

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
