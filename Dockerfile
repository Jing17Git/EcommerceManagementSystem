FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

RUN apt-get update && apt-get install -y \
git unzip zip curl nodejs npm \
libpng-dev libonig-dev libxml2-dev \
libzip-dev default-mysql-client

# Install PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy project
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
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

EXPOSE 8080

CMD ["frankenphp", "run"]