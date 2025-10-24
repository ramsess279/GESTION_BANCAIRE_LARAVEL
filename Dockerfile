FROM php:8.3-cli

# Arguments (optional for local build caching)
ARG user=laravel
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only composer files first to leverage Docker layer cache
COPY composer.json composer.lock ./

# Install PHP dependencies (no-dev for production) without running scripts yet (artisan not copied)
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --no-scripts --optimize-autoloader

# Copy application code
COPY . .

# Now that artisan exists, finalize autoload and run post-autoload scripts
RUN composer dump-autoload --optimize --no-dev --no-interaction && \
    composer run-script post-autoload-dump || true

# Ensure storage and cache directories are writable
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R ug+rwx storage bootstrap/cache

# Try to optimize caches (do not fail the build if env not fully available)
RUN php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true && \
    php artisan storage:link || true

# Expose and use Render's PORT
ENV PORT=8080
EXPOSE 8080

# Start Laravel using PHP built-in server, binding to Render's $PORT
CMD ["bash", "-lc", "php -d variables_order=EGPCS -S 0.0.0.0:$PORT -t public"]