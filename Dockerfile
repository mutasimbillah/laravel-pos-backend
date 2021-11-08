FROM composer:2 as composer
WORKDIR /app

COPY composer.json composer.lock /app/
RUN composer install  \
    --ignore-platform-reqs \
    --no-ansi \
    --no-autoloader \
    --no-dev \
    --no-interaction \
    --no-scripts

COPY . /app/
RUN composer dump-autoload --optimize --classmap-authoritative


FROM nazmulpcc/php:8.0-cli

LABEL maintainer="Nazmul Alam <nazmulpcc@gmail.com>"
WORKDIR /app
COPY --from=composer /app .
RUN chown -R www-data:www-data /app && apk add nodejs npm

CMD php artisan octane:start --host=0.0.0.0 --port=8000
