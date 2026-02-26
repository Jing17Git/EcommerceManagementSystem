FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

# Install system dependencies including composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nodejs \
    npm

# Install Composer manually (IMPORTANT ⭐)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies + build assets
RUN npm install
RUN npm run build

# Laravel permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

# Cache Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 8080

CMD ["sh","-c","frankenphp php-server --listen 0.0.0.0:${PORT} --root public/"]