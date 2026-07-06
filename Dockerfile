FROM composer:2 AS vendor
WORKDIR /app
RUN apk add --no-cache icu-dev && docker-php-ext-install intl
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader

FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install intl mysqli pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && a2enmod rewrite headers

RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN chown -R www-data:www-data writable \
    && chmod -R 775 writable

EXPOSE ${PORT}
