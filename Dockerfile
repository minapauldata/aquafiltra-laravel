FROM composer:latest AS composer

FROM php:8.2-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install zip pdo pdo_mysql mbstring \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

ENV DB_CONNECTION=mysql
ENV DB_HOST=gondola.proxy.rlwy.net
ENV DB_PORT=38033
ENV DB_DATABASE=railway
ENV DB_USERNAME=root
ENV DB_PASSWORD=NYlJkaNEnIUlgSNDvMFOaJtOgLMtPPsU
ENV APP_KEY=base64:6LwLL/aYqgi1IuDi0RsXEryhjC+wVqEU0JE4vf8fOKw=
ENV APP_ENV=production
ENV APP_URL=https://aquafiltra-laravel.up.railway.app

RUN composer install --no-dev --optimize-autoloader
RUN php artisan storage:link

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000