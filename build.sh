cd /opt

sudo yum install epel-release -y

sudo yum install gcc libxml2-devel libXpm-devel gmp-devel libicu-devel \
t1lib-devel aspell-devel openssl-devel bzip2-devel libcurl-devel \
libjpeg-devel libvpx-devel libpng-devel freetype-devel readline-devel \
libtidy-devel libxslt-devel libmcrypt-devel pcre-devel curl-devel \
mysql-devel ncurses-devel gettext-devel net-snmp-devel libevent-devel \
libtool-ltdl-devel libc-client-devel postgresql-devel bison gcc make wget -y


sudo yum install nginx -y
sudo yum install git -y


rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

yum install php70w php70w-fpm php70w-opcache \
php70w-bcmath  php70w-cli php70w-common \
php70w-devel php70w-gd php70w-intl php70w-mbstring \
php70w-mcrypt php70w-mysqlnd php70w-pdo php70w-pecl-imagick \
php70w-xml  php70w-json --skip-broken -y

yum remove ImageMagick-last-6.9.5.10-1.el7.remi.x86_64 -y
yum install php70w-pecl-imagick -y

##Install

yum install redis -y

git clone https://github.com/phpredis/phpredis.git

cd phpredis
git checkout php7
phpize
./configure
make && make install
echo "extension=redis.so" > /etc/php.d/redis.ini

curl -sS https://getcomposer.org/installer | php

mv composer.phar /usr/bin/composer

#
cd ../
wget http://repo.mysql.com/mysql-community-release-el7-5.noarch.rpm
sudo rpm -ivh mysql-community-release-el7-5.noarch.rpm
yum update -y
sudo yum install -y  mysql-server
sudo systemctl start mysqld
#sudo mysql_secure_installation

## Install PhalconPHP
yum install re2c -y
git clone --depth=1 https://github.com/phalcon/zephir
cd zephir
./install -c

cd ../
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon
zephir build
echo "extension=phalcon.so" > /etc/php.d/phalcon.ini



## Chu y can set
#listen.owner = nginx
#sed -i "s|;listen.owner = nginx|listen.owner = nginx|g" /etc/php-fpm.d/www.conf
sed -i "s|listen = 127.0.0.1:9000|listen = /var/run/php-fpm/www.sock|g" /etc/php-fpm.d/www.conf
sed -i "s|;listen.owner = nobody|listen.owner = nginx|g" /etc/php-fpm.d/www.conf
service php-fpm restart


##

sudo yum install fail2ban -y
sudo systemctl enable fail2ban

## FFmpeg
rpm --import http://li.nux.ro/download/nux/RPM-GPG-KEY-nux.ro
sudo rpm -Uvh http://li.nux.ro/download/nux/dextop/el7/x86_64/nux-dextop-release-0-5.el7.nux.noarch.rpm
sudo yum install ffmpeg ffmpeg-devel -y

yum install gcc-c++ openssl-devel -y
yum install nodejs -y
npm install -g node-gyp

## Mongo

pecl install mongodb
echo "extension=mongodb.so" > /etc/php.d/mongodb.ini

## Install elastic

service nginx restart
service php-fpm restart
service redis start

