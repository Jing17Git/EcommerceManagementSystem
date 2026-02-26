FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
git unzip zip curl nodejs npm \
libpng-dev libonig-dev libxml2-dev libzip-dev default-mysql-client

# Enable PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy project FIRST
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP + Node dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# Permissions
RUN mkdir -p storage/framework/sessions \
storage/framework/views \
storage/framework/cache \
storage/framework/testing \
storage/logs \
bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# IMPORTANT ⭐ (This keeps container alive)
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]