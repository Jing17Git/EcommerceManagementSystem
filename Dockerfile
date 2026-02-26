FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
git \
unzip \
zip \
curl \
nodejs \
npm

# Copy project files FIRST
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Node dependencies + build
RUN npm install
RUN npm run build

# Laravel permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
storage/logs bootstrap/cache \
&& chmod -R 775 storage bootstrap/cache

# Laravel optimizations
RUN php artisan storage:link || true
RUN php artisan optimize:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 8080

CMD ["frankenphp", "run"]