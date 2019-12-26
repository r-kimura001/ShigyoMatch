FROM php:7.3.0RC6-fpm-alpine3.8
# timezone
ARG TZ
WORKDIR /var/www/laravel
COPY ./docker/php/php.ini /usr/local/etc/php/
COPY ./laravel/ /var/www/laravel/

RUN apk update && apk add --no-cache \
  freetype-dev libjpeg-turbo-dev libpng-dev libmcrypt-dev \
  git vim unzip tzdata \
  libmcrypt-dev \
  libltdl && \
  docker-php-ext-install pdo_mysql mysqli mbstring gd iconv && \
  cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
  apk del tzdata && \
  rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  composer global require hirak/prestissimo && \
  composer install --no-dev  && \
  chmod -R a+w storage/ bootstrap/cache
