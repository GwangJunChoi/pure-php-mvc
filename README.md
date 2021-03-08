# pure-php-mvc
- [github](https://github.com/GwangJunChoi/pure-php-mvc)
##environment
- PHP >= 7.3,
- JSON PHP Extension
- PDO PHP Extension

- nginx config
```
server {
    listen 80;
    server_name {server_name};
    root {root_folder};

    #add_header X-Frame-Options "SAMEORIGIN";
    #add_header X-XSS-Protection "1; mode=block";
    #add_header X-Content-Type-Options "nosniff";

    dav_methods PUT DELETE MKCOL COPY MOVE;
    dav_ext_methods PROPFIND OPTIONS;

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```