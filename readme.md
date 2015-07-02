# Pre-Install
Service | Where to get it
---- | ----
xcode | https://itunes.apple.com/de/app/xcode/id497799835
node.js | https://nodejs.org/dist/v0.12.5/node-v0.12.5.pkg

# During Install

## Add settings
- In mysql settings table

Name | Value
---- | ----
userDir | /Users/travis
homesteadFlag | 0
homesteadLocation | /Users/travis/Code/Personal/Homestead
nginxFlag | 1
nginxLogLocation | /Users/travis/Library/Application Support/com.webcontrol.WebControl/nginx/logs

# Nginx (local)
```
$NGINX_LOCATION=which nginx
sudo visudo
$USER  ALL=(ALL) NOPASSWD: $NGINX_LOCATION
```

# Homestead
`sudo chmod +a "$USER allow read,write,execute,append" /etc/hosts`