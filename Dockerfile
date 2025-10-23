FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

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

USER $user

# Copy existing application directory contents
COPY . /var/www

# Note: Ownership and permissions are handled by Docker, no need to change manually

# Install PHP dependencies
RUN git config --global --add safe.directory /var/www && composer update --no-interaction --no-scripts --no-autoloader

# Note: Node.js assets are not built in Docker for Render deployment. Build them locally if needed.

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]