FROM php:8.4-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends git libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip \
    && curl -fsSL https://xdebug.org/files/xdebug-3.5.0.tgz -o /tmp/xdebug.tgz \
    && mkdir -p /tmp/xdebug \
    && tar -xzf /tmp/xdebug.tgz -C /tmp/xdebug --strip-components=1 \
    && cd /tmp/xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make -j"$(nproc)" \
    && make install \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/xdebug /tmp/xdebug.tgz \
    && a2enmod rewrite \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug-settings.ini
COPY . .

RUN composer install --no-interaction --prefer-dist

EXPOSE 80
