FROM ubuntu:18.04

MAINTAINER "Shahrokh Nabavi <info@nabavi.nl>"
LABEL Version="1.0" \
      Author="Shahrokh"

# Setting the following environment so that no question/dialog is asked during apt-get insta
ENV DEBIAN_FRONTEND="noninteractive"

# Install to packages which are required later by PHP about asking of time and encription
RUN apt-get update && \
    apt-get install -y gnupg tzdata && \
    echo "UTC" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata

RUN apt-get update && \
    # some utilies for ubuntu
    apt-get install -y nano vim git curl wget zip unzip supervisor sqlite3 \
    # install apache
    apache2 libapache2-mod-php \
    # install php
    php7.2-fpm php7.2-cli \
    php7.2-pgsql php7.2-sqlite3 php7.2-gd \
    php7.2-curl php7.2-memcached \
    php7.2-imap php7.2-mysql php7.2-mbstring \
    php7.2-xml php7.2-zip php7.2-bcmath php7.2-soap \
    php7.2-intl php7.2-readline php7.2-xdebug \
    php-msgpack php-igbinary && \
    # install composer
    php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && \
    # clean up our image
    mkdir /run/php && \
    apt-get -y autoremove && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# install and active phpfpm, PHP FastCGI implementation with some additional features useful for sites of any size, especially busier sites.
RUN cd /tmp && \
    wget http://mirrors.kernel.org/ubuntu/pool/multiverse/liba/libapache-mod-fastcgi/libapache2-mod-fastcgi_2.4.7~0910052141-1.2_amd64.deb && \
    dpkg -i libapache2-mod-fastcgi_2.4.7~0910052141-1.2_amd64.deb && \
    apt install -f && \
    a2enmod actions fastcgi alias proxy_fcgi

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    service apache2 start && \
    rm -f /var/www/html/index.html

COPY docker/app/index.php /var/www/html/index.php
COPY docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/app/000-default.conf /etc/apache2/sites-available/000-default.conf

CMD ["supervisord"]