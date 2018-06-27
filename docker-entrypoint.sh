#!/bin/sh
set -e
#chown -R www-data:www-data /var/www/html
sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-enabled/000-default.conf
# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
        set -- apache2-foreground "$@"
fi
exec "$@"
