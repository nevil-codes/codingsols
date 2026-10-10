# syntax=docker/dockerfile:1

# ---- Front-end assets --------------------------------------------------------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
RUN npm run build

# ---- Application -------------------------------------------------------------
# serversideup/php bundles PHP-FPM, Nginx, Composer and the pdo_pgsql / pdo_mysql
# extensions, and serves the app on port 8080 as an unprivileged user.
FROM serversideup/php:8.4-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1 \
    LOG_CHANNEL=stderr \
    # On start-up: storage:link, migrate --force and config/route/view caching.
    # Set AUTORUN_ENABLED=false on worker and scheduler containers.
    AUTORUN_ENABLED=true

WORKDIR /var/www/html

COPY --chown=www-data:www-data composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

RUN composer dump-autoload --no-dev --optimize \
    && php artisan package:discover --ansi
