FROM gsviec/nginx-php:7.3
COPY docker-nginx-site.conf /etc/nginx/nginx.conf
COPY php.ini-production /usr/local/etc/php/php.ini

RUN apk add ffmpeg gcc g++ autoconf make
RUN pecl install -o -f redis-5.1.1 \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN docker-php-ext-install bcmath
# production-ready dependencies
COPY . /var/www
RUN composer install --prefer-dist --no-interaction
