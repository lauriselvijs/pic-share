FROM php:8.4-fpm-alpine

# Install system dependencies and PHP extension build deps
RUN apk update && apk add --no-cache \
    git \
    curl \
    supervisor \
    dcron \
    bash \
    nodejs \
    npm \
    mysql-client \
    mariadb-connector-c \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    zlib-dev \
    icu-dev \
    autoconf \
    gcc \
    g++ \
    make \
    nginx \
    && mkdir -p /run/nginx \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
        gd \
        xml \
        dom \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del autoconf gcc g++ make  # Clean up build tools

# Add Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Install dependencies
RUN composer install --optimize-autoloader
RUN npm install && npm run build

# Copy Supervisor and cron config
COPY ./docker/production/supervisord.conf /etc/supervisord.conf
COPY ./docker/production/crontab /etc/cron.d/crontab
RUN chmod 0644 /etc/cron.d/crontab && crontab /etc/cron.d/crontab

# Copy and configure entrypoint
COPY ./docker/test/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
