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