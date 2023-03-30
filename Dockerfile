FROM php:8.2-zts

RUN apt update && apt install -y libmagickwand-dev --no-install-recommends
RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN pecl install parallel
RUN docker-php-ext-enable parallel
