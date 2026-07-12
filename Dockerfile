FROM php:8.2-fpm

# Install system dependencies and required binaries (Tesseract OCR & poppler-utils for pdf-to-text)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    tesseract-ocr \
    poppler-utils \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to match host UID (1000) for file permissions on Linux
RUN useradd -G www-data -u 1000 -d /home/dev -m -s /bin/bash dev

# Set working directory
WORKDIR /var/www

# Copy existing application directory permissions
COPY --chown=dev:www-data . /var/www

# Change current user to dev
USER dev

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
