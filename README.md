# INSTALLATION

## Before you begin
1. If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

2. Install composer-asset-plugin needed for yii assets management
```bash
composer global require "fxp/composer-asset-plugin"
```
#### Clone repository manually
```
git clone https://github.com/dacom-dark-sun/mapala/
```
#### Install composer dependencies
```
composer install
```

### REQUIREMENTS
The minimum requirement by this application template that your Web server supports PHP 5.5.0.
Required PHP extensions:
- intl
- gd
- mcrypt


### Setup application
1. Open `.env` in the project root.
2. Adjust settings in `.env` file
	- Set debug mode and your current environment
	```
	YII_DEBUG   = true
	YII_ENV     = dev
	```
	- Set DB configuration for test-mode
	```
	DB_DSN           = mysql:host=127.0.0.1;port=3306;unix_socket='/tmp/mysql/mysql.sock';dbname=yii2
	DB_USERNAME      = 
	DB_PASSWORD      = 
	```

	- Set application canonical urls
	```
	FRONTEND_URL    = http://mapala.dev
	BACKEND_URL     = http://backend.mapala.dev
	STORAGE_URL     = http://storage.mapala.dev
	```

3. Run in command line
```
php console/yii app/setup
```

4. Download and import sql-dump to mysql: https://yadi.sk/d/5uypwPG13AfKkX

### Configure your web server
Copy `vhost.conf.dist` to `vhost.conf`, change it with your local settings and copy (symlink) it to nginx `sites-enabled` directory.
Or configure your web server with three different web roots:
- yii2-starter-kit.dev => /path/to/yii2-starter-kit/frontend/web
- backend.yii2-starter-kit.dev => /path/to/yii2-starter-kit/backend/web
- storage.yii2-starter-kit.dev => /path/to/yii2-starter-kit/storage/web


#### Configure your web server
##### Apache
This is an example single domain config for apache (need change document Root)
```
<VirtualHost *:80>
    ServerName mapala.dev

    RewriteEngine on
    # the main rewrite rule for the frontend application
    RewriteCond %{HTTP_HOST} ^yii2-starter-kit.dev$ [NC]
    RewriteCond %{REQUEST_URI} !^/(backend/web|admin|storage/web)
    RewriteRule !^/frontend/web /frontend/web%{REQUEST_URI} [L]
    # redirect to the page without a trailing slash (uncomment if necessary)
    #RewriteCond %{REQUEST_URI} ^/admin/$
    #RewriteRule ^(/admin)/ $1 [L,R=301]
    # disable the trailing slash redirect
    RewriteCond %{REQUEST_URI} ^/admin$
    RewriteRule ^/admin /backend/web/index.php [L]
    # the main rewrite rule for the backend application
    RewriteCond %{REQUEST_URI} ^/admin
    RewriteRule ^/admin(.*) /backend/web$1 [L]

    DocumentRoot /your/path/to/yii2-starter-kit
    <Directory />
        Options FollowSymLinks
        AllowOverride None
        AddDefaultCharset utf-8
    </Directory>
    <Directory "/your/path/to/yii2-starter-kit/frontend/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    <Directory "/your/path/to/yii2-starter-kit/backend/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    <Directory "/your/path/to/yii2-starter-kit/storage/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    <FilesMatch \.(htaccess|htpasswd|svn|git)>
        Require all denied
    </FilesMatch>
</VirtualHost>
```

##### Nginx
This is an example single domain config for nginx

```
server {
    listen 80;

    root /var/www;
    index index.php index.html;

    server_name yii2-starter-kit.dev;

    charset utf-8;

    # location ~* ^.+\.(jpg|jpeg|gif|png|ico|css|pdf|ppt|txt|bmp|rtf|js)$ {
    #   access_log off;
    #   expires max;
    # }

    location / {
        root /var/www/frontend/web;
        try_files $uri /frontend/web/index.php?$args;
    }

    location /admin {
        try_files  $uri /admin/index.php?$args;
    }

    # storage access
    location /storage {
        try_files  $uri /storage/web/index.php?$args;
    }

    client_max_body_size 32m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass php-fpm;
        fastcgi_index index.php;
        include fastcgi_params;

        ## Cache
        # fastcgi_pass_header Cookie; # fill cookie valiables, $cookie_phpsessid for exmaple
        # fastcgi_ignore_headers Cache-Control Expires Set-Cookie; # Use it with caution because it is cause SEO problems
        # fastcgi_cache_key "$request_method|$server_addr:$server_port$request_uri|$cookie_phpsessid"; # generating unique key
        # fastcgi_cache fastcgi_cache; # use fastcgi_cache keys_zone
        # fastcgi_cache_path /tmp/nginx/ levels=1:2 keys_zone=fastcgi_cache:16m max_size=256m inactive=1d;
        # fastcgi_temp_path  /tmp/nginx/temp 1 2; # temp files folder
        # fastcgi_cache_use_stale updating error timeout invalid_header http_500; # show cached page if error (even if it is outdated)
        # fastcgi_cache_valid 200 404 10s; # cache lifetime for 200 404;
        # or fastcgi_cache_valid any 10s; # use it if you want to cache any responses
    }
}

## PHP-FPM Servers ##
upstream php-fpm {
    server unix:/var/run/php/php7.0-fpm.sock;
}
```

That`s all. After provision application will be accessible on http://mapala.dev
If not, try it: http://mapala.dev/frontend/web/site/index

### Demo Users
```
Login: webmaster
Password: webmaster

Login: manager
Password: manager

Login: user
Password: user
```
