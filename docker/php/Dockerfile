FROM php:7.3.0-fpm

RUN apt-get update \
  && apt-get install -y --no-install-recommends libpq-dev \
  && docker-php-ext-install mysqli pdo_pgsql pdo_mysql

#COPY ./php.ini /usr/local/etc/php/
#COPY ./www.conf /usr/local/etc/php/

