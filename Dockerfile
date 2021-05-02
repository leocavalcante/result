FROM php:7.4

RUN pecl install pcov \
 && docker-php-ext-enable pcov