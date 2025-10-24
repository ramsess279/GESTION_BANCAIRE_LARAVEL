FROM php:8.3-fpm

# Arguments defined in docker-compose.yml
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
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install PHP dependencies (as root to avoid permission issues)
RUN git config --global --add safe.directory /var/www && composer update --no-interaction --no-scripts --no-autoloader

# Change ownership to the user after installing dependencies
RUN chown -R $user:$user /var/www

# Switch to the user
USER $user

# Note: Ownership and permissions are handled by Docker, no need to change manually

# Note: Node.js assets are not built in Docker for Render deployment. Build them locally if needed.

# Install Nginx
RUN apt-get install -y nginx

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80 and start Nginx and PHP-FPM
EXPOSE 80
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]