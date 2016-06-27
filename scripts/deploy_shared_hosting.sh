#!/usr/bin/env bash

cd "../$( dirname "${BASH_SOURCE[0]}" )"

/usr/local/cpanel/3rdparty/bin/git pull origin master
php composer.phar install --no-dev
php composer.phar dump-autoload -o
php artisan config:cache