# ==============================================
# Agency Builder CRM - Tier 1 (DigitalOcean Ready)
# ==============================================

FROM php:8.2-apache

# Enable Apache rewrite (for Laravel routing)
RUN a2enmod rewrite

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application source code
COPY . /var/www/html

# Install Laravel dependencies (skip dev packages)
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Fix file and directory permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache to serve Laravel public directory properly
RUN echo '<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options +Indexes +FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Enable Laravel routing (mod_rewrite)
RUN a2enmod rewrite

# Expose port 80 (DigitalOcean maps external traffic to this)
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
