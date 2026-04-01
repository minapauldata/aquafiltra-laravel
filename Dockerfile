FROM dunglas/frankenphp:php8.2.30-bookworm

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT