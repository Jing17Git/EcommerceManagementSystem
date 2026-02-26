FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip zip nodejs npm \
    && rm -rf /var/lib/apt/lists/*

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install
RUN npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 8080

CMD ["sh","-c","frankenphp php-server --listen 0.0.0.0:${PORT} --root public/"]