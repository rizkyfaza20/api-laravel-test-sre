FROM php:7.4-cli

WORKDIR /var/www/html/public

COPY . /var/www/html/public

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


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer update --prefer-dist --no-plugins --no-scripts

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html/public/

# Expose port 8000
EXPOSE 8000

# Start the PHP CLI application (you can adjust this as needed)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
