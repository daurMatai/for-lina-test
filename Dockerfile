FROM php:8.0.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
   build-essential \
   git \
   curl \
   libpng-dev \
   libjpeg62-turbo-dev \
   libfreetype6-dev \
   locales \
   libpq-dev \
   libpng-dev \
   libonig-dev \
   libxml2-dev \
   zip \
   jpegoptim optipng pngquant gifsicle \
   unzip \
   curl \
   libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath soap pdo pdo_pgsql pgsql

# Install GD extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/

# Set working directory
WORKDIR /var/www

USER $user
