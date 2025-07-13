FROM php:8.3-fpm

# Install libs
RUN apt-get update && apt-get install -y  \
    iputils-ping \
    build-essential \
    autoconf \
    curl \
    libcurl4-openssl-dev  \
    pkg-config  \
    libzip-dev  \
    libxml2-dev \
    libonig-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP Extensions
RUN docker-php-ext-install \
    mbstring bcmath mysqli pdo pdo_mysql xml zip curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.8.3 --install-dir=/usr/local/bin --filename=composer

# Install Node/NPM
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
  && apt-get install -y nodejs

# Copy project
COPY . /var/www/html

# Install packages
RUN composer install
RUN npm install

# Set storage/cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html
