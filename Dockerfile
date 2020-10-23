FROM gsviec/nginx-php:7.3

RUN apk add ffmpeg gcc g++ autoconf make
RUN pecl install -o -f redis-5.1.1 \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN docker-php-ext-install bcmath
RUN rm -rf html
COPY docker-nginx-site.conf /etc/nginx/nginx.conf
COPY php.ini-production /usr/local/etc/php/php.ini
# production-ready dependencies
COPY . /var/www
RUN composer install --prefer-dist --no-interaction
