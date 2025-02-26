FROM php:8.1-apache

# Install necessary PHP extensions
RUN apt-get -o "Acquire::https::Verify-Peer=false" update && apt-get -o "Acquire::https::Verify-Peer=false" install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libldap2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu \
    && docker-php-ext-install gd mysqli pdo pdo_mysql ldap \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*  # Clean up to reduce image size

# Set working directory
WORKDIR /var/www/html

# Copy application files from the Git repository
COPY ./app /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
