FROM php:8.4-cli

ENV APP_ENV=production \
    APP_DEBUG=false \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/app/database/teacher-schedule.sqlite

RUN apt-get update && apt-get install -y \
    curl zip unzip git \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN mkdir -p bootstrap/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    public/uploads/profile-pictures

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN touch database/teacher-schedule.sqlite

RUN chmod -R 775 storage bootstrap/cache public/uploads database

EXPOSE 8000

CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
