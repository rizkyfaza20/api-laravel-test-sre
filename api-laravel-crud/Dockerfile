FROM php:7.4-fpm

# Set the working directory
WORKDIR /var/www/public

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


COPY . .


RUN composer install --no-interaction --no-dev --optimize-autoloader


RUN chown -R www-data:www-data /var/www/public \
    && chmod -R 755 /var/www/public/storage

EXPOSE 8000
CMD ["php-fpm"]
