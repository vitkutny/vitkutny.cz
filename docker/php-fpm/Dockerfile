FROM php:7.1-fpm-alpine

RUN docker-php-ext-install opcache && docker-php-ext-enable opcache
RUN apk update && apk add autoconf && apk add gcc && apk add libc-dev && apk add make && pecl install xdebug
