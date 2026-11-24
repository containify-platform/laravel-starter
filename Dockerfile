# The production image: FrankenPHP (PHP's app server, built on Caddy) serving
# Laravel on plain HTTP port 8080. HTTPS ends at Containify's edge.
FROM dunglas/frankenphp:1-php8.5

ENV SERVER_NAME=:8080 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

RUN install-php-extensions pdo_pgsql intl zip pcntl bcmath && \
    cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev

# Run as an ordinary user. FrankenPHP's capability to bind ports 80 and 443
# isn't needed on 8080.
RUN useradd --create-home laravel && \
    setcap -r /usr/local/bin/frankenphp && \
    chown -R laravel:laravel /config/caddy /data/caddy storage bootstrap/cache
USER laravel

EXPOSE 8080
# Cache config, routes and views when the replica starts, when its variables
# are known: the build doesn't have them.
CMD ["sh", "-c", "php artisan optimize && exec frankenphp run --config /etc/frankenphp/Caddyfile --adapter caddyfile"]
