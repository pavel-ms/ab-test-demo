web: vendor/bin/heroku-php-nginx -C nginx.conf

--nginx.conf--
location / {
    root /app/myapp/public;

    try_files $uri @rewriteapp;
}

location @rewriteapp {
    rewrite ^(.*)$ /myapp/public/index.php/$1 last;
}