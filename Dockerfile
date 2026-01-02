#  FROM php:8.2-fpm

# # Set working directory
# WORKDIR /var/www/html

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     libzip-dev \
#     zip \
#     unzip \
#     nodejs \
#     npm

# # Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# # Get latest Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www/html

# # Copy existing application directory permissions
# COPY --chown=www-data:www-data . /var/www/html

# # Install PHP dependencies
# RUN composer install --no-interaction --optimize-autoloader --no-dev

# # Install Node dependencies and build assets
# RUN npm install && npm run build

# # Set proper permissions
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 9000 and start php-fpm server
# EXPOSE 9000
# CMD ["php-fpm"]
