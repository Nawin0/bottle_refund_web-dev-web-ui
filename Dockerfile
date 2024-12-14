#
# Use this dockerfile to run the application.
#
# Start the server using docker-compose:
#
#   docker-compose build
#   docker-compose up
#
# NOTE: In future examples replace {{volume_name}} with your projects desired volume name
#
# You can install dependencies via the container:
#
#   docker-compose run {{volume_name}} composer install
#
# You can manipulate dev mode from the container:
#
#   docker-compose run {{volume_name}} composer development-enable
#   docker-compose run {{volume_name}} composer development-disable
#   docker-compose run {{volume_name}} composer development-status
#
# OR use plain old docker
#
#   docker build -f Dockerfile-dev -t {{volume_name}} .
#   docker run -it -p "8080:80" -v $PWD:/var/www {{volume_name}}
#
FROM php:8.2-apache

# system dependecies
RUN apt-get update \
 && apt-get remove -y mariadb-server mariadb-client \
 && apt-get install -y \
 git \
 libssl-dev \
 default-mysql-client \
 libmcrypt-dev \
 libicu-dev \
 libpq-dev \
 libjpeg62-turbo-dev \
 libjpeg-dev  \
 libpng-dev \
 zlib1g-dev \
 libonig-dev \
 libxml2-dev \
 libzip-dev \
 unzip

# PHP dependencies
RUN docker-php-ext-install \
 gd \
 intl \
 mbstring \
 pdo \
 pdo_mysql \
 mysqli \
 zip

# Apache
RUN a2enmod rewrite \
 && echo "ServerName docker" >> /etc/apache2/apache2.conf

# Update the default Apache site configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

 # Set the Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Composer
RUN curl -sS https://getcomposer.org/installer | php && \
 mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html
