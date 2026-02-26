FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
git unzip zip curl nodejs npm

# Copy project FIRST
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# Only create directories (NO Laravel commands here)
RUN mkdir -p storage/framework/sessions \
storage/framework/views \
storage/framework/cache \
storage/framework/testing \
storage/logs \
bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["frankenphp", "run"]