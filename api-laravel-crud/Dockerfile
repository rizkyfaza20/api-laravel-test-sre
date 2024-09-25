FROM php:7.4.33-fpm AS build

WORKDIR /var/www/html/

COPY . /var/www/html/

COPY .env.development .env

RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    unzip \
    git \
    curl \
    libzip-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install --optimize-autoloader --no-dev

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


FROM php:7.4-fpm-alpine3.16 AS production

# Copy existing application directory permissions
WORKDIR /var/www/html/

RUN apk --no-cache add \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    unzip \
    git \
    libcurl \
    curl \
    curl-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev

RUN docker-php-ext-install \
    curl \
    pdo_mysql \
    mysqli \
    mbstring \
    zip \
    exif \
    pcntl \
    gd

COPY --from=build --chown=www:www /var/www/html /var/www/html/

# Expose port 8000
EXPOSE 8000

# Start the PHP CLI application (you can adjust this as needed)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
